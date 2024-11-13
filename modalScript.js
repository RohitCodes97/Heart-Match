
var modal = document.getElementById("imageModal");
var modalImage = document.getElementById("modalImage");


var images = document.querySelectorAll(".thumbnail");

images.forEach(function(img) {
    img.addEventListener("click", function() {
        modal.style.display = "block";  
        modalImage.src = img.src;      
    });
});


function closeModal() {
    modal.style.display = "none"; // Hide the modal
}
