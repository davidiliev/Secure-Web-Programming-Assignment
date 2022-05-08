function mobileMenu() {
    var x = document.getElementById("navbar");
    if (x.className === "navbarclass") {
      x.className += " responsive";
    } else {
      x.className = "navbarclass";
    }
  }