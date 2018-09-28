var XMLHttpRequestObject = createXMLHttpRequestObject();
function createXMLHttpRequestObject()
{
  var XMLHttpRequestObject = false;
  
  try
  {
    XMLHttpRequestObject = new XMLHttpRequest();
  }
  catch(e)
  {
    var aryXmlHttp = new Array(
                               "MSXML2.XMLHTTP",
                               "Microsoft.XMLHTTP",
                               "MSXML2.XMLHTTP.6.0",
                               "MSXML2.XMLHTTP.5.0",
                               "MSXML2.XMLHTTP.4.0",
                               "MSXML2.XMLHTTP.3.0"
                               );
    for (var i=0; i<aryXmlHttp.length && !XMLHttpRequestObject; i++)
    {
      try
      {
        XMLHttpRequestObject = new ActiveXObject(aryXmlHttp[i]);
      } 
      catch(e){document.write("createXMLHttpRequestObject: XMLHttpRequestObject Error");}
    }
  }
  
  if (!XMLHttpRequestObject)
  {
    alert("Error: failed to create the XMLHttpRequest object.");
  }
  else 
  {
    return XMLHttpRequestObject;
  }
}

function checkFormInput(keyEvent, dataSource, idForm)
{
  keyEvent = (keyEvent) ? keyEvent: window.event;
  input = (keyEvent.target) ? keyEvent.target : keyEvent.srcElement;
  
  if(keyEvent.type == "checkbox")
  {
    keyEvent.value = keyEvent.checked;
  }
  else if(keyEvent.type == "radio")
  {
    keyEvent.value = keyEvent.checked;
    if (keyEvent.value)
    {
      for(i=0; i<document.getElementById(idForm).elements.length - 1; i++)
      {
        /*Debug
        alert(document.getElementById(idForm).elements[i].name);
        alert(document.getElementById(idForm).elements[i].value);
        alert(document.getElementById(idForm).elements[i].checked);
        */
        if(document.getElementById(idForm).elements[i].name==keyEvent.name)
        {
          /*alert(document.getElementById(idForm).elements[i].name+':'+document.getElementById(idForm).elements[i].value);*/
          document.getElementById(idForm).elements[i].value = document.getElementById(idForm).elements[i].checked;
        }
      }
    } /* End: if (keyEvent.value)*/
  } /* End: if (keyEvent.type == "change")*/
}

function sendFormData(idForm, dataSource, divID, ifLoading)
{
  var postData='';
  var strReplaceTemp;
  
  if(XMLHttpRequestObject)
  {
    XMLHttpRequestObject.open("POST", dataSource);
    XMLHttpRequestObject.setRequestHeader("Method", "POST " + dataSource + " HTTP/1.1");
	  XMLHttpRequestObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	  
    XMLHttpRequestObject.onreadystatechange = function()
    {
      if (XMLHttpRequestObject.readyState == 4 &&
          XMLHttpRequestObject.status == 200)
      {
        try
        {
          var objDiv = document.getElementById(divID);
          objDiv.innerHTML = XMLHttpRequestObject.responseText;
        }
        catch(e){document.write("sendFormData: getElementById(divID) Error");}
      }
      else
      {
        if(ifLoading)
        {
          try
          {
            var objDiv = document.getElementById(divID);
            objDiv.innerHTML = "<img src=loading.gif>";
          }
          catch(e){document.write("sendFormData->ifLoading: getElementById(divID) Error");}
        }
      }
    }
    
    for(i=0; i<document.getElementById(idForm).elements.length - 1; i++)
    {
      strReplaceTemp = document.getElementById(idForm).elements[i].name.replace(/\[\]/i, "");
      postData += "&aryFormData["+strReplaceTemp+"][]="+document.getElementById(idForm).elements[i].value;
    }
    
    postData += "&parm="+new Date().getTime();
    try
    {
      XMLHttpRequestObject.send(postData);
    }
    catch(e){document.write("sendFormData: XMLHttpRequestObject.send Error");}
  }
}