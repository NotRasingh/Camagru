/* var cbx = document.getElementById("chbx");
cbx.addEventListener("change", notifsub()); */
 


function checkcheck()
{
   var xhr = new XMLHttpRequest();
   var url = "ajaxfuncs.php";
   var newvars="mypostname="+"testttt";
   xhr.open("POST", url, true);
   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   xhr.onreadystatechange = function(){
   if (xhr.readyState == 4 && xhr.status == 200)
   {
       chkstat = xhr.responseText;
       if(chkstat == "1")
       {
           box.checked = true;
       }
       else{
           box.checked = false;
       }
   }
   };
xhr.send(newvars);  

}

