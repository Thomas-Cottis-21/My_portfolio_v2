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

//naming variables to the preference buttons in the navbar
    let buttonGreen = document.getElementById("green");
    let buttonOrange = document.getElementById("orange");
    let buttonRed = document.getElementById("red");
    let buttonLightBlue = document.getElementById("light-blue");
    let buttonDarkBlue = document.getElementById("dark-blue");
    let buttonGray = document.getElementById("gray");
    
//naming variables that define each color
    const green = "#a2c80a";
    const orange = "#ffc600";
    const red = "#ff4000";
    const lightBlue = "#00beff";
    const darkBlue = "#007eff";
    const gray = "#aaaaaa";

//first function that loops through all the elements with the color class, creates and applies the color class, passing in the argument type, which will later be filled by one of the color variables
function changeColor(type) {
    const colored = document.getElementsByClassName("color");
    for (let i = 0; i < colored.length; i++) {
        colored[i].style.color = type;
    }
    localStorage.setItem("savedColor", type);
    console.log("the color should have changed");
}

//second function that loops through all the elements with the border-color class, creates and applies the border-color class, passing in the argument type, which will later be filled by one of the color variables
function changeBorderColor(typeBorder) {
    const colored = document.getElementsByClassName("border-color");
    for (let i = 0; i < colored.length; i++) {
        colored[i].style.borderColor = typeBorder;
    }
}

//third function that loops through all the elements with the background-color class, creates and applies the backgrouond-color class, passing in the argument type, which will later be filled by one of the color variables
function changeBackgroundColor(typeBackground) {
    const colored = document.getElementsByClassName("background-color");
    for (let i = 0; i < colored.length; i++) {
        colored[i].style.backgroundColor = typeBackground;
    }
}

//event listeners that will trigger the functions above to create and apply the classes
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

//accessing local storage variable on load in order to accuratley run switch
    let selectColor = localStorage.getItem("savedColor");

//the switch that will apply the current color saved on the local storage
    switch(selectColor) {
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
    //localStorage.clear();