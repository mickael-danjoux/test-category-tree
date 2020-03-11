var app = new Vue({
    delimiters: ['${', '}'],
    el: '#table',
    methods: {
        deleteItem: function (id) {
            Swal.fire({
                title: 'Voulez-vous supprimer cet élément?',
                text: "Cette action est irréversible",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Annuler',
                confirmButtonText: 'Supprimer'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`http://127.0.0.1:8000/admin/category/delete/` + id)
                        .then(response => {
                            document.getElementById('item-' + id).remove();
                            Swal.fire(
                                'Supprimée!',
                                'La catégorie à bien été supprimée',
                                'success'
                            )
                        })
                        .catch(e => {
                            Swal.fire(
                                'Erreur!',
                                'La catégorie n\as pas pu être supprimée : ' + e,
                                'error'
                            )
                        });

                }
            })
        }
    }
});