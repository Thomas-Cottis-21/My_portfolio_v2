//back to top button hide and appear
const toTopAppear = () => {

    //fromTop fullscreen = 300
    let element = document.getElementById("backToTop");

    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        element.classList.add("show");
        console.log("appearing");
    } else {
        element.classList.remove("show");
        console.log("hidding");
    }
}
window.addEventListener("scroll", toTopAppear);

//Dark Mode

let currentState = localStorage.getItem("darkMode");
let darkModeButton = document.getElementById("toggleDm");

const enableDarkMode = () => {
    document.body.classList.add("dark-mode");
    localStorage.setItem("darkMode", "enabled");
    console.log("enabled");
}

const disableDarkMode = () => {
    document.body.classList.remove("dark-mode");
    localStorage.setItem("darkMode", "disabled");
    console.log("disabled");
}

if (currentState == "enabled") {
    enableDarkMode();
}

const trigger = () => {
    currentState = localStorage.getItem("darkMode");

    if (currentState !== "enabled") {
        enableDarkMode();
    } else {
        disableDarkMode();
    }
}
darkModeButton.addEventListener("click", trigger);
//localStorage.clear();