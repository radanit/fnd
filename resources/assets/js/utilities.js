export function errorMessage(msgStr){
  if(msgStr.isArray){
    if(Object.keys(msgStr).length>1){
      var errors ="<ul>"
      for(var k in msgStr) {
           errors += "<li>"+msgStr[k]+"</li><br/>";         
        }
        return(errors+"</ul>");
    }
    else{
        return(msgStr);
    }
  }
  else{
    return(msgStr);
  }
}