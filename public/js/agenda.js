document.addEventListener("DOMContentLoaded", (event) => {
    document
        .getElementById("kineSelect")
        .addEventListener("change", function () {
            console.log("Sélection changée, valeur : ", this.value); // Ajout pour le test
            var kineId = this.value;
            if (kineId) {
                fetch(`/agenda/${kineId}`)
                    .then((response) => response.text())
                    .then((html) => {
                        document.getElementById("creneauxContainer").innerHTML =
                            html;
                    });
            }
        });
});
