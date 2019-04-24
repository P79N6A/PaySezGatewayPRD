#!perl
#

use strict;
use warnings;

use CGI::Fast qw(:standard);
use DBI;
use Exception::Class::TryCatch;

use lib './REJBlib';
use callback;

$| = 1;


use CGI::Carp::DebugScreen (
    engine => 'TT',
    debug          => 1,
    lines          => 5,
    modules        => 1,
    environment    => 1,
    raw_error      => 1,
    overload       => 1,
);

my $q = new CGI;

my %params = $q->Vars;

my $tid = $params{'trans_id'};  # these three lines may well vary from one processor to another,
                                # as they may use different request paramter IDs to represent these
                                # concepts
#$tid = 'f40c8a3287a7784da5890cf9c45adf79a773cd92REITUMU';
my $success = $params{'result'};
$success = $params{'status'} unless defined $success;
$success = 1 unless defined $success;
my $code = $params{'code'};
my $url;

my ($trid,$aid,$plat,$proc,$mid) = callback::find_transactions($tid);
#die "(\$trid,\$aid,\$plat,\$proc,\$mid) = ($trid,$aid,$plat,$proc,$mid)\n";
open(FOUT, ">> cup.callback.debug.txt");
print FOUT "\$tid = $tid\nBefore callback::update_transaction_record($trid,$success,$code,$plat)\n\$mid = $mid\n";
close(FOUT);
$url = get_url($mid);
&callback::update_transaction_record($trid,$success,$code,$plat);
open(FOUT, ">> cup.callback.debug.txt");
print FOUT "After callback::update_transaction_record($trid,$success,$code,$plat)\n";
close(FOUT);
&callback::update_action_record($aid,$success);
open(FOUT, ">> cup.callback.debug.txt");
print FOUT "After callback::update_action_record($trid,$success,$code,$plat)\n";
close(FOUT);
&callback::notify($url,\%params) if ((defined $url) && (length($url) > 0));
open(FOUT, ">> cup.callback.debug.txt");
print FOUT "After callback::notify\n";
close(FOUT);
print $q->header; # this, and the next line, are used in merchant callback script, but
                  # NOT the consumer callbacks- they get the redirection headers instead!
print $q->start_html('Data Complete');
print "<h1>completed</h1>";
print $q->end_html;

exit(0);

sub get_url {
  my $m = shift;
  my $sql = "SELECT mer_callback FROM merchants WHERE idmerchants = $m;";
#die $sql;
  try eval {
    my $db = 'profitorius';
    my $hostname = 'localhost';
    my $user = 'rejbyers';
    my $dbpwd = 'Didr39Qcab';
    my $dbh = DBI->connect_cached("DBI:mysql:database=$db;host=$hostname",$user,$dbpwd,{RaiseError => 1}) or die "Failed to connect to the DB.\n";
    my $sth = $dbh->prepare($sql);
    $sth->execute() or die $sth->errstr;
    my ($rv) = $sth->fetchrow_array;
    $sth->finish;
    $dbh->disconnect;
    $rv =~ s/^http:/^https:/;# if url was stored with the protocol, make sure it is secure
    unless ($rv =~ m/^https:/) {# otherwise, add protocol to the stored URL.
	$rv = 'https://' . $rv;
    }
    return $rv;
  };
  if ( catch my $err) {
    die "We died a nasty death: ",$err->error,"\n\n";
  }
}
