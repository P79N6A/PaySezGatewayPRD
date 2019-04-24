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
$tid = 'f40c8a3287a7784da5890cf9c45adf79a773cd92REITUMU';
my $success = $params{'result'};
$success = 1;
my $code = $params{'code'};
my $url;

my ($trid,$aid,$plat,$proc,$mid) = callback::find_transactions($tid);
#die "(\$trid,\$aid,\$plat,\$proc,\$mid) = ($trid,$aid,$plat,$proc,$mid)\n";
$url = get_url($mid);
&callback::notify($url,\%params) if ((defined $url) && (length($url) > 0));
print $q->header; # this, and the next line, are used in merchant callback script, but
                  # NOT the consumer callbacks- they get the redirection headers instead!
print $query->start_html('Data Complete');
print "<h1>completed</h1>";
print $query->end_html;

exit(0);

sub get_url {
  my $m = shift;
  my $s = shift;
  my $field = ($s == 1) ? 'client_success_notify' : 'client_fail_notify';
  my $sql = "SELECT $field FROM merchants WHERE idmerchants = $m;";
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
