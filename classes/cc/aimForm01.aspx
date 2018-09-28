<!--

###########################################################
#                                                         #
#  D O C U M E N T A T I O N                              #
#                                                         #
#  This code sample has been successfully tested on       #
#  third-party web servers and performed according to     #
#  documented Advanced Integration Method (AIM)           #
#  standards.                                             #
#                                                         #
#  Last updated September 2004.                           #
#                                                         #
#  For complete and freely available documentation,       #
#  please visit the Authorize.Net web site at:            #
#                                                         #
#  http://www.authorizenet.com/support/guides.php         #
#                                                         #
###########################################################

###########################################################
#                                                         #
#  D I S C L A I M E R                                    #
#                                                         #
#  WARNING: ANY USE BY YOU OF THE SAMPLE CODE PROVIDED    #
#  IS AT YOUR OWN RISK.                                   #
#                                                         #
#  Authorize.Net provides this code "as is" without       #
#  warranty of any kind, either express or implied,       #
#  including but not limited to the implied warranties    #
#  of merchantability and/or fitness for a particular     #
#  purpose.                                               #
#                                                         #
#                                                         #
###########################################################

###########################################################
#                                                         #
#  .N E T      D E V E L O P E R S                        #
#                                                         #
#  The provided sample code is merely a blue print,       #
#  demonstrating one possible approach to making AIM      #
#  work, by way of performing the required HTTPS POST     #
#  operation.                                             #
#                                                         #
#  1. This sample code is not a tutorial. If you are      #
#  unfamiliar with specific programming functions and     #
#  concepts, please consult the necessary reference       #
#  materials.                                             #
#                                                         #
#  2. This sample code is provided "as is," meaning that  #
#  we will not be able to assist individual e-commerce    #
#  developers with specific programming issues, relating  #
#  to the availability or non-availability of specific    #
#  modules, code libraries or other requirements to make  #
#  this code work on your specific web server             #
#  configuration.                                         #
#                                                         #
#  3. If you cannot get this sample code to work, please  #
#  do not contact Authorize.Net to complain. However, if  #
#  you encounter specific issues and would like to find   #
#  out what you can do to resolve a specific problem, we  #
#  would be happy to help you find a suitable solution    #
#  if time allows and if resources are available. We do   #
#  not promise, however, that we will be able to solve    #
#  your programming problems nor do we make any           #
#  guarantees or promises -- either express or            #
#  implied -- that we will even attempt to address any    #
#  programming issues that anyone encounters using our    #
#  sample code.                                           #
#                                                         #
#  Again, this sample code merely serves as blue print    #
#  for e-commerce developers who either are inexperienced #
#  performing HTTPS POST operations or simply want an     #
#  example of how other developers have dealt with this   #
#  challenge in the past.                                 #
#                                                         #
#                                                         #
###########################################################

###########################################################
#                                                         #
#  P R E R E Q U I S I T E S                              #
#                                                         #
#  To submit any kind of transaction (even test           #
#  transactions) to Authorize.Net, you need to provide    #
#  valid Authorize.Net account information (a merchant    #
#  log-in ID and a valid merchant transaction key).       #
#                                                         #
#  Authorize.Net is unable to assist you with IIS         #
#  troubleshooting and other issues relating to server    #
#  configuration.                                         #
#                                                         #
#                                                         #
###########################################################

###########################################################
#                                                         #
#  C O N T A C T    I N F O R M A T I O N                 #
#                                                         #
#  For specific questions,                                #
#  please contact Authorize.Net's Integration Services:   #
#                                                         #
#  integration at authorize dot net                       #
#                                                         #
#                                                         #
###########################################################

###########################################################
#                                                         #
#  C O N T A C T    I N F O R M A T I O N                 #
#                                                         #
#  For specific questions,                                #
#  please contact Authorize.Net's Integration Services:   #
#                                                         #
#  integration at authorize dot net                       #
#                                                         #
#  Please remember that we cannot support individual      #
#  e-commerce developers with programming problems and    #
#  other issues that could be easily solved by referring  #
#  to the available reference materials.                  #
#                                                         #
###########################################################

###########################################################
#                                                         #
#  A I M   I N   A   N U T S H E L L                      #
#                                                         #
###########################################################
#                                                         #
#  1. You gather all the required transaction data on     #
#  your secure web site.                                  #
#                                                         #
#  2. The transaction data gets submitted (via HTTPS      #
#  POST) to Authorize.Net as one long string, consisting  #
#  of specific name/value pairs.                          #
#                                                         #
#  3. When performing the HTTPS POST operation, you       #
#  remain on the same web page from which you’ve          #
#  performed the operation.                               #
#                                                         #
#  4. Authorize.Net immediately returns a transaction     #
#  response string to the same web page from which you    #
#  have performed the HTTPS POST operation.               #
#                                                         #
#  5. You may then parse the response string and act      #
#  upon certain response criteria, according to your      #
#  business needs.                                        #
#                                                         #
#                                                         #
###########################################################

-->

<%@ Import Namespace="System.Net" %>
<%@ Import Namespace="System.IO" %>
<script language="C#" runat="server">
   void Page_Load(Object Src, EventArgs E) {
      myPage.Text = readHtmlPage("https://test.authorize.net/gateway/transact.dll");
      'Uncomment the line ABOVE for shopping cart testing OR uncomment the line BELOW for live accounts
      'myPage.Text = readHtmlPage("https://secure.authorize.net/gateway/transact.dll")
   }

   private String readHtmlPage(string url)
   {
      String result = "";
      String strPost = "x_login=YOUR-LOG-IN-ID&x_tran_key=YOUR-TRANSACTION-KEY&x_method=CC&x_type=AUTH_CAPTURE&x_amount=1.00&x_delim_data=TRUE&x_delim_char=|&x_relay_response=FALSE&x_card_num=4111111111111111&x_exp_date=052009&x_test_request=TRUE&x_version=3.1";
      StreamWriter myWriter = null;
      
      HttpWebRequest objRequest = (HttpWebRequest)WebRequest.Create(url);
      objRequest.Method = "POST";
      objRequest.ContentLength = strPost.Length;
      objRequest.ContentType = "application/x-www-form-urlencoded";
      
      try
      {
         myWriter = new StreamWriter(objRequest.GetRequestStream());
         myWriter.Write(strPost);
      }
      catch (Exception e) 
      {
         return e.Message;
      }
      finally {
         myWriter.Close();
      }
         
      HttpWebResponse objResponse = (HttpWebResponse)objRequest.GetResponse();
      using (StreamReader sr = 
         new StreamReader(objResponse.GetResponseStream()) )
      {
         result = sr.ReadToEnd();

         // Close and clean up the StreamReader
         sr.Close();
      }
      return result;
   }   
</script>
<html>
<body>
<b>The content on this web page is the result of an HTTP POST operation to Authorize.Net, using the Advanced Implementation method (AIM).<br>
<br/>
</b><hr/>
<asp:literal id="myPage" runat="server"/>
</body>
</html>
