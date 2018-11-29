function openNav() {
    document.getElementById("mySidenav").style.width = "200px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

   function showmodal() {
    document.getElementById("id01").style.display = "block";
}

function register(){
    window.location.href = 'signup.php'; 
}

function change(){
    window.location.href = 'edit.php';
}

function logout(){
    window.location.href = 'exit.php';
}

