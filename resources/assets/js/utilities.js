function  msg(msgStr){
    var errors ="<ul>"
      for(var k in msgStr) {
           errors += "<li>"+msgStr[k]+"</li><br/>";
           
        }
        return(errors+"</ul>");
  }