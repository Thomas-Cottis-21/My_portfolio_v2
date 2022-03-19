//back to top button hide and appear
const toTopAppear = () => {

    //fromTop fullscreen = 300
    let toTop = document.getElementById("backToTop");

    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        toTop.classList.add("show");
        darkModeButton.classList.add("show");
        console.log("appearing");
    } else {
        toTop.classList.remove("show");
        darkModeButton.classList.remove("show");
        console.log("hidding");
    }
}
window.addEventListener("scroll", toTopAppear);

//Dark Mode

let currentState = localStorage.getItem("darkMode");
let darkModeButton = document.getElementById("toggleDm");

const enableDarkMode = () => {
    document.body.classList.add("dark-mode");
    darkModeButton.classList.add("light-mode-button");
    darkModeButton.classList.remove("dark-mode-button");
    localStorage.setItem("darkMode", "enabled");
    console.log("enabled");
}

const disableDarkMode = () => {
    document.body.classList.remove("dark-mode");
    darkModeButton.classList.remove("light-mode-button");
    darkModeButton.classList.add("dark-mode-button");
    localStorage.setItem("darkMode", "disabled");
    console.log("disabled");
}

if (currentState == "enabled") {
    enableDarkMode();
} else {
    disableDarkMode();
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