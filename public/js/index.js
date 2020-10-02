const startButton = document.getElementById("start");
const stopButton = document.getElementById("stop");

const sidenav = document.getElementById("sidenav");

startButton.addEventListener('click', clicked);
function clicked(){
    sidenav.classList.add("show");
    sidenav.classList.remove("stopp");
    startButton.classList.remove("opa1");
   startButton.classList.add("opa0");
   stopButton.classList.remove("opa0");
   stopButton.classList.add("opa1");
 
   
}
stopButton.addEventListener('click', unClick);
function unClick(){
    sidenav.classList.add("stopp");
    sidenav.classList.remove("show");
    startButton.classList.remove("opa0");
    startButton.classList.add("opa1");
    stopButton.classList.remove("opa1");
    stopButton.classList.add("opa0");
  

}