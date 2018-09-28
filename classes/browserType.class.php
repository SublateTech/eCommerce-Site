<?
/*********************************************************************
                    - Browser Detection Class -
( Copyright 2006 - Patrick Mahoney - Online-Net-Business.Com )

I created this class as a way for my website builder script to know
what type of browser the end user is using. This is not a powerful
class, it is simple, and simply does what I need it to. It only supports
recent and most popular browsers, with a few extras tossed in for good
measure.

You're free to use this class for any reason what-so-ever so long as
this and all text and files remain with this class package.
**********************************************************************
USAGE:
include ( "browserType.class.php" );
$browser = new browserType();
$browser->GetBrowser();
echo $browser->browserinfo;

This will output an abbreviation of the browser being used, for example,
if the end user is using Internet Explorer, it will echo 'ie' to the
screen. If you are going to use this for detecting the browser to
display different information to your end user based on their browser
version, then just simply write a function that will handle the output
information from the class for what you need. You should already know
how to do this, so I will not go into a big example. A very simple way
to use this might be like the following example:

EXAMPLE:

$browser = new browserType();
$browser->GetBrowser();

if ( $browser->browserinfo == "ie" ) {
  // Do Something Here
} elseif ( $browser->browserinfo == "op" ) {
  // Do Something Else Here
} else {
  // Do Another Something Here
}
*********************************************************************/

class browserType {
  
  var $browserinfo;
  
  function GetBrowser() {
    
    $useragent_am = stristr ( $_SERVER['HTTP_USER_AGENT'], "amaya"         );
    $useragent_cb = stristr ( $_SERVER['HTTP_USER_AGENT'], "Crazy Browser" );
    $useragent_mx = stristr ( $_SERVER['HTTP_USER_AGENT'], "Maxthon"       );
    $useragent_ab = stristr ( $_SERVER['HTTP_USER_AGENT'], "Avant Browser" );
    $useragent_fl = stristr ( $_SERVER['HTTP_USER_AGENT'], "Flock"         );
    $useragent_ff = stristr ( $_SERVER['HTTP_USER_AGENT'], "Firefox"       );
    $useragent_ns = stristr ( $_SERVER['HTTP_USER_AGENT'], "Netscape"      );
    $useragent_sa = stristr ( $_SERVER['HTTP_USER_AGENT'], "Safari"        );
    $useragent_ga = stristr ( $_SERVER['HTTP_USER_AGENT'], "Galeon"        );
    $useragent_kq = stristr ( $_SERVER['HTTP_USER_AGENT'], "Konqueror"     );
    $useragent_lx = stristr ( $_SERVER['HTTP_USER_AGENT'], "Lynx"          );
    $useragent_op = stristr ( $_SERVER['HTTP_USER_AGENT'], "Opera"         );
    $useragent_ie = stristr ( $_SERVER['HTTP_USER_AGENT'], "MSIE"          );
    
    // IE and FireFox are last in the list because some browsers will have
    // them listed in their UA strings before their browsers version.
    if     ( $useragent_am ) { $this->browserinfo = "am"; }
    elseif ( $useragent_cb ) { $this->browserinfo = "cb"; }
    elseif ( $useragent_mx ) { $this->browserinfo = "mx"; }
    elseif ( $useragent_ab ) { $this->browserinfo = "ab"; }
    elseif ( $useragent_fl ) { $this->browserinfo = "fl"; }
    elseif ( $useragent_ns ) { $this->browserinfo = "ns"; }
    elseif ( $useragent_sa ) { $this->browserinfo = "sa"; }
    elseif ( $useragent_ga ) { $this->browserinfo = "ga"; }
    elseif ( $useragent_kq ) { $this->browserinfo = "kq"; }
    elseif ( $useragent_lx ) { $this->browserinfo = "lx"; }
    elseif ( $useragent_op ) { $this->browserinfo = "op"; }
    elseif ( $useragent_ff ) { $this->browserinfo = "ff"; }
    elseif ( $useragent_ie ) { $this->browserinfo = "ie"; }
    else                     { $this->browserinfo =  "";  }
    
  }
  
}
?>