//pathname of the current document
let path = window.location.pathname;


//dark mode, navbar and back to top appear and disappear based on scroll from top height
const toTopAppear = () => {

//naming variables for what will appear and disappear (anvbar, back to top and dark mode buttons)
    let toTop = document.getElementById("backToTop");
    let navBar = document.getElementById("navBar");
    let dropDown = document.getElementById("dropdownMenu");

//this funcion shows the buttons and changes the navbar css to dark insead of light
    const buttonEnable = () => {
        toTop.classList.add("show");
        darkModeButton.classList.add("show");
        navBar.classList.add("navDark");
        navBar.classList.remove("navLight");
        dropDown.classList.add("navDark");
        dropDown.classList.remove("navLight");
    }

//this function makes the buttons disappear and changes the navbar to light instead of dark css
    const buttonDisable = () => {
        toTop.classList.remove("show");
        darkModeButton.classList.remove("show");
        navBar.classList.remove("navDark");
        navBar.classList.add("navLight");
        dropDown.classList.remove("navDark");
        dropDown.classList.add("navLight");
    }

//this calls the functions above when the page has reached 600 pixels from the top
    if (document.body.scrollTop > 600 || document.documentElement.scrollTop > 600) {
        buttonEnable();
        console.log("appearing");
    } else {
        buttonDisable();
        console.log("disappearing");
    }
}
console.log(path);

//this calls the function on scroll
if (path == "/index.php") {
    console.log('you should be seeing this in index');
    window.addEventListener("scroll", toTopAppear);   
}

//Dark Mode

//naming variables linked to local storage in order to check status
let currentState = localStorage.getItem("darkMode");

//naming the button
let darkModeButton = document.getElementById("toggleDm");

//this function changes the background to dark by adding dark class to body element as well as changing the button style respectively
const enableDarkMode = () => {
    if (path == "/index.php") {
        darkModeButtonEnable();
    }
    document.body.classList.add("dark-mode");
    localStorage.setItem("darkMode", "enabled");
    console.log("enabled");
}

//this function changes the background to light by adding dark class to body element as well as changing the button style respectively
const disableDarkMode = () => {
    if (path == "/index.php") {
        darkModeButtonDisable();
    }
    document.body.classList.remove("dark-mode");
    localStorage.setItem("darkMode", "disabled");
    console.log("disabled");
}

//this function sets the parameters executed by the functions above in order to change the style of the dark mode button
const darkModeButtonEnable = () => {
    darkModeButton.classList.add("light-mode-button");
    darkModeButton.classList.remove("dark-mode-button");
}

//this function sets the parameters executed by the functions above in order to change the style of the dark mode button
const darkModeButtonDisable = () => {
    darkModeButton.classList.remove("light-mode-button");
    darkModeButton.classList.add("dark-mode-button");
}

//this function checks the status of the body element so that on load the system rememebers if it was enabled or disabled based on local storage status
    if (currentState == "enabled") {
        enableDarkMode();
    } else {
        disableDarkMode();
    }

//this function triggers the change on click as well as updating the variable
const trigger = () => {
    currentState = localStorage.getItem("darkMode");

    if (currentState !== "enabled") {
        enableDarkMode();
    } else {
        disableDarkMode();
    }
}

//runs trigger on click
if (path == "/index.php") {
darkModeButton.addEventListener("click", trigger);
//localStorage.clear();
}


//adding class "color" to all queries in order to change color of entire site based on one class

//accessing local storage variable in order to accuratley run switch
    let selectColor = localStorage.getItem("savedColor");

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
if (path == "/index.php") {
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
}

//the switch that will apply the current color saved on the local storage
const findColor = () => {
    switch(selectColor) {
        case "#a2c80a":
            changeColor(green);
            changeBorderColor(green);
            changeBackgroundColor(green);
            console.log(selectColor);
            break;
        case "#ffc600":
            changeColor(orange);
            changeBorderColor(orange);
            changeBackgroundColor(orange);
            console.log(selectColor);
            break;
        case "#ff4000":
            changeColor(red);
            changeBorderColor(red);
            changeBackgroundColor(red);
            console.log(selectColor);
            break;
        case "#00beff":
            changeColor(lightBlue);
            changeBorderColor(lightBlue);
            changeBackgroundColor(lightBlue);
            console.log(selectColor);
            break;
        case "#007eff":
            changeColor(darkBlue);
            changeBorderColor(darkBlue);
            changeBackgroundColor(darkBlue);
            console.log(selectColor);
            break;
        case "#aaaaaa":
            changeColor(gray);
            changeBorderColor(gray);
            changeBackgroundColor(gray);
            console.log(selectColor);
            break;
    }
//localStorage.clear();








}
findColor();