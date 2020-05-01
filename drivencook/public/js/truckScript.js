function unsetTruck(id) {
    if (confirm("Voulez vous vraiment retirer le camion au franchisé ?")) {
        if (!isNaN(id)) {
            urlB = urlB.replace(':id', id);
            $.ajax({
                url: urlB,
                method: "delete",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data == id) {
                        window.location.reload();
                    } else {
                        alert("Une erreur est survenue lors de la suppression, veuillez raffraichir la page");
                    }
                },
                error: function () {
                    alert("Une erreur est survenue lors de la suppression, veuillez raffraichir la page");
                }
            })
        }
    }
}
