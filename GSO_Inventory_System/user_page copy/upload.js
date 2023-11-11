document.addEventListener("DOMContentLoaded", function() {
    const excelForm = document.getElementById("excelForm");
    const excelFileInput = document.getElementById("excelFile");
    const uploadButton = document.getElementById("uploadButton");
    const statusDiv = document.getElementById("status");

    uploadButton.addEventListener("click", function() {
        const file = excelFileInput.files[0];
        if (file) {
            const formData = new FormData();
            formData.append("excelFile", file);

            fetch("upload.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.text())
            .then(message => {
                statusDiv.innerHTML = message;
            })
            .catch(error => {
                console.error("Error:", error);
                statusDiv.innerHTML = "An error occurred during the upload.";
            });
        } else {
            statusDiv.innerHTML = "Please select an Excel file.";
        }
    });
});