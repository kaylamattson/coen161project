// script.js
fetch('gameover.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        username: 'John Doe',
        age: 25
    })
})
.then(response => response.text())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
