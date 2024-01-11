document.addEventListener("DOMContentLoaded", function () {
    var selectedKineName = "";
    var kineSelect = document.getElementById("kineSelect");

    kineSelect.addEventListener("change", function () {
        var selectedOption = this.options[this.selectedIndex];
        selectedKineName = selectedOption.text; // Obtenez le nom complet du kiné sélectionné
    });

    var confirmationModal = document.getElementById("confirmationModal");
    confirmationModal.addEventListener("show.bs.modal", function (event) {
        var button = event.relatedTarget;
        var creneauId = button.getAttribute("data-creneau-id");
        var creneauDate = button.getAttribute("data-creneau-date");
        var creneauHeure = button.getAttribute("data-creneau-heure");

        var modalDate = confirmationModal.querySelector("#selectedDate");
        var modalTime = confirmationModal.querySelector("#selectedTime");
        var modalDoctor = confirmationModal.querySelector("#selectedDoctor");
        modalDate.textContent = creneauDate;
        modalTime.textContent = creneauHeure;
        modalDoctor.textContent = selectedKineName; // Utilisez le nom du kiné sélectionné

        var confirmBtn = confirmationModal.querySelector("#confirmRdvBtn");
        confirmBtn.onclick = function () {
            var kineId = kineSelect.value; // ID du kiné sélectionné
            fetch("/ajouterrendezvous", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    creneauId: creneauId,
                    kineId: kineId,
                    dateRdv: creneauDate,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data.message);
                    window.location.href = "/profile";
                })
                .catch((error) => {
                    console.error(
                        `Erreur lors de l'ajout du rendez-vous:`,
                        error
                    );
                });
            console.log(
                "Rendez-vous confirmé pour le créneau : " +
                    creneauId +
                    " à la date : " +
                    creneauDate +
                    " avec " +
                    selectedKineName
            );
        };
    });
});
