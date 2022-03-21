//dark mode, navbar and back to top appear and disappear based on scroll from top height
const toTopAppear = () => {

    //fromTop fullscreen = 300
    let toTop = document.getElementById("backToTop");
    let navBar = document.getElementById("navBar");
    const buttonEnable = () => {
        toTop.classList.add("show");
        darkModeButton.classList.add("show");
        navBar.classList.add("navDark");
        navBar.classList.remove("navLight");
    }

    const buttonDisable = () => {
        toTop.classList.remove("show");
        darkModeButton.classList.remove("show");
        navBar.classList.remove("navDark");
        navBar.classList.add("navLight");
    }

    if (document.body.scrollTop > 600 || document.documentElement.scrollTop > 600) {
        buttonEnable();
        console.log("appearing");
    } else {
        buttonDisable();
        console.log("disappearing");
    }
}
window.addEventListener("scroll", toTopAppear);

//Dark Mode

let currentState = localStorage.getItem("darkMode");
let darkModeButton = document.getElementById("toggleDm");

const enableDarkMode = () => {
    document.body.classList.add("dark-mode");
    darkModeButtonEnable();
    localStorage.setItem("darkMode", "enabled");
    console.log("enabled");
}

const disableDarkMode = () => {
    document.body.classList.remove("dark-mode");
    darkModeButtonDisable();
    localStorage.setItem("darkMode", "disabled");
    console.log("disabled");
}

const darkModeButtonEnable = () => {
    darkModeButton.classList.add("light-mode-button");
    darkModeButton.classList.remove("dark-mode-button");
}

const darkModeButtonDisable = () => {
    darkModeButton.classList.remove("light-mode-button");
    darkModeButton.classList.add("dark-mode-button");
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