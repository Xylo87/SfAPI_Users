
const container = document.querySelector(".API_JS_test")

async function call() {
    
    let response = await fetch('https://localhost:8000/api/membres')
    let data = await response.json()

    data.member.forEach(membre => {
        
        container.innerHTML += membre.last.toUpperCase() + ' ' + membre.first + '<br>'
    });
}

call()