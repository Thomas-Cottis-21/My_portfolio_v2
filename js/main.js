//dark mode, navbar and back to top appear and disappear based on scroll from top height
const toTopAppear = () => {

    //fromTop fullscreen = 600
    let toTop = document.getElementById("backToTop");
    let navBar = document.getElementById("navBar");
    let dropDown = document.getElementById("dropdownMenu");
    const buttonEnable = () => {
        toTop.classList.add("show");
        darkModeButton.classList.add("show");
        navBar.classList.add("navDark");
        navBar.classList.remove("navLight");
        dropDown.classList.add("navDark");
        dropDown.classList.remove("navLight");
    }

    const buttonDisable = () => {
        toTop.classList.remove("show");
        darkModeButton.classList.remove("show");
        navBar.classList.remove("navDark");
        navBar.classList.add("navLight");
        dropDown.classList.remove("navDark");
        dropDown.classList.add("navLight");
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

//adding class "color" to all queries in order to change color of entire site based on one class
    let test = document.getElementById("buttonTest");

    let buttonGreen = document.getElementById("green");
    let buttonOrange = document.getElementById("orange");
    let buttonRed = document.getElementById("red");
    let buttonLightBlue = document.getElementById("light-blue");
    let buttonDarkBlue = document.getElementById("dark-blue");
    let buttonGray = document.getElementById("gray");

    const green = "#a2c80a";
    const orange = "#ffc600";
    const red = "#ff4000";
    const lightBlue = "#00beff";
    const darkBlue = "#007eff";
    const gray = "#aaaaaa";

function changeColor(type) {
    const colored = document.getElementsByClassName("color");
    for (let i = 0; i < colored.length; i++) {
        colored[i].style.color = type;
    }
    localStorage.setItem("color", type);
}

function changeBorderColor(typeBorder) {
    const colored = document.getElementsByClassName("border-color");
    for (let i = 0; i < colored.length; i++) {
        colored[i].style.borderColor = typeBorder;
    }
}

function changeBackgroundColor(typeBackground) {
    const colored = document.getElementsByClassName("background-color");
    for (let i = 0; i < colored.length; i++) {
        colored[i].style.backgroundColor = typeBackground;
    }
}

    let savedColor = localStorage.getItem("color");

    switch(savedColor) {
        case "#a2c80a":
            changeColor(green);
            changeBorderColor(green);
            changeBackgroundColor(green);
            break;
        case "#ffc600":
            changeColor(orange);
            changeBorderColor(orange);
            changeBackgroundColor(orange);
            break;
        case "#ff4000":
            changeColor(red);
            changeBorderColor(red);
            changeBackgroundColor(red);
            break;
        case "#00beff":
            changeColor(lightBlue);
            changeBorderColor(lightBlue);
            changeBackgroundColor(lightBlue);
            break;
        case "#007eff":
            changeColor(darkBlue);
            changeBorderColor(darkBlue);
            changeBackgroundColor(darkBlue);
            break;
        case "#aaaaaa":
            changeColor(gray);
            changeBorderColor(gray);
            changeBackgroundColor(gray);
            break;
    }

    buttonGreen.addEventListener("click", function() {
        changeColor(green);
        changeBorderColor(green);
        changeBackgroundColor(green);
    });
    buttonOrange.addEventListener("click", function() {
        changeColor(orange);
        changeBorderColor(orange);
        changeBackgroundColor(orange);
    });
    buttonRed.addEventListener("click", function() {
        changeColor(red);
        changeBorderColor(red);
        changeBackgroundColor(red);
        
    });
    buttonLightBlue.addEventListener("click", function() {
        changeColor(lightBlue);
        changeBorderColor(lightBlue);
        changeBackgroundColor(lightBlue);
    });
    buttonDarkBlue.addEventListener("click", function() {
        changeColor(darkBlue);
        changeBorderColor(darkBlue);
        changeBackgroundColor(darkBlue);
    });
    buttonGray.addEventListener("click", function() {
        changeColor(gray);
        changeBorderColor(gray);
        changeBackgroundColor(gray);
    });