let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");
let container2 = document.querySelector(".container2");
let ue = document.querySelector(".ue");
let info = document.querySelector(".info");
let container3 = document.querySelector(".container3");
let suppr = document.querySelector(".suppr");
let ecrit = document.querySelector(".ecrit");


closeBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    var main = document.getElementsByClassName("main");
    if(sidebar.classList.contains("open")){
    for (var i = 0; i < main.length; ++i) {
        main[i].style.marginLeft="250px";
      }
    }else{
        for (var i = 0; i < main.length; ++i) {
            main[i].style.marginLeft="0px";
          }
    }
});

function myFunction() {
    if(sidebar.classList.contains("open")){
        container2.style.cssText = ' display: flex; margin-top: -150px; margin-left: 350px; grid-template-columns: 1fr 1fr 1fr;gap: 10px 200px;width: 1005px;';
        suppr.style.cssText = 'margin-left: -600px;border: solid;background-color: aqua;height: 100px;width: 200px;margin-top: 500px;';
        ue.style.cssText=' border: solid;height: 400px;width: 400px;background-color: #FC6D6D;';
        info.style.cssText=' border: solid;height: 400px;width: 400px;background-color: #a1ceee;';
        ecrit.style.cssText='position: fixed;margin-left:787px ; margin-top:-650px ;';
    
    }


    else{

        container2.style.cssText='border: solid;display: flex;margin-top: -150px;margin-left: 250px;grid-template-columns: 1fr 1fr 1fr;gap: 10px 200px;width: 1005px;';
        suppr.style.cssText ='margin-left: -600px;border: solid;background-color: aqua;height: 100px;width: 200px;margin-top: 500px;';
        ue.style.cssText='border: solid;height: 400px;width: 400px;background-color: #FC6D6D;';
        info.style.cssText='border: solid;height: 400px;width: 400px;background-color: #a1ceee;';
        ecrit.style.cssText='position: fixed;margin-left:690px ;margin-top:-650px ;';
        for (var i = 0; i < main.length; ++i) {
            main[i].style.marginLeft="0px";
        }
    }
}




// following are the code to change sidebar button(optional)
function menuBtnChange() {
    if(sidebar.classList.contains("open")){
    closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the icons class
    
    }else {
    closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the icons class
    }
}