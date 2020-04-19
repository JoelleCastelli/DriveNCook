let adult = new Date(new Date().setFullYear(new Date().getFullYear() - 19));
adult = adult.toISOString().substr(0, 10);
document.querySelector("#birthdate").value = adult;