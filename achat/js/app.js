function togglePopup(){
    let popup = document.querySelector("#popup-overlay");
    popup.classList.toggle("open");
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  
  function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
  


if(getCookie("lastpopup") == "" || getCookie("lastpopup") == null)
{
    setCookie("lastpopup", new Date().getTime())
    togglePopup()
}

let lastPopup = new Date(parseInt(getCookie("lastpopup")))
let currTime = new Date().getTime()
let shouldShow = false

if (currTime - lastPopup.getTime() > 1000000) 
{ 
    // showing popup

    setCookie("lastpopup", new Date().getTime())
    togglePopup()
}