const username = document.getElementById("username")
const email = document.getElementById("email")
const password = document.getElementById("password")
const form = document.getElementById("form")
const firstname = document.getElementById("firstname")
const errorElements = document.getElementById("error")



form.addEventListener("submit", (e) =>{
    let messages = []
    if(username.value === "" || username.value === null){
        messages.push("Please enter a password")
    }
    if(password.value === "" || password.value === null){
        messages.push("Please enter a password")
    }
    if(firstname.value === "" || firstname.value === null){
        messages.push("Please enter a username")
    }

    if(messages.length > 0){
        e.preventDefault()
        errorElements.innerText = messages.join(",")
    }
})