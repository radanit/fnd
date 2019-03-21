export function errorMessage(msgStr){
  if(Object.keys(msgStr).length>1){
    var errors ="<ul>"
    for(var k in msgStr) {
         errors += "<li>"+msgStr[k]+"</li><br/>";         
      }
      return(errors+"</ul>");
  }
  else{
    var errors =""
    for(var k in msgStr) {
         errors += msgStr[k];         
      }
      return(errors);
  }
}