$(document).ready(function(){

   
    // ici j'affiche la partie formation
    $('.corps_admin').on(
    'click',
    '.sous_menu_admin_formation',
    function(ee)
    {
        ee.preventDefault();

        $.ajax({
            url : 'gestion.php?action=formation',
            type: 'post',
            contentType : false,
            processData : false,
            success: function(donnees2){        

                $('.contenu_admin').empty();
                $('.contenu_admin').append(donnees2);


            }
        });

    })


        // ici j'affiche la partie formation le formulaire pour ajouter
        $('.corps_admin').on(
        'click',
        '.admin_ajouter_formation',
        function(ee)
        {  
            ee.preventDefault();
    
            $.ajax({
                url : 'gestion.php?action=ajout_formation',
                type: 'post',
                contentType : false,
                processData : false,
                success: function(donnees2){        

                    $('.contenu_admin').empty();
                    $('.contenu_admin').append(donnees2);
                    
                    
                }
            });
    
        })
        
        // ici j'affiche la partie formation quand on ajoute la formation
        $('.corps_admin').on(
        'submit',
        '.valider_formulaire',
        function(e)
        {
            e.preventDefault();

            var myForm = document.getElementById('myForm');

            let form_data = new FormData(myForm);    
            
            $.ajax({
                url : 'gestion.php?action=ajouter',
                type: 'post',
                data : form_data,
                contentType : false,
                processData : false,
                success: function(donnees2){        

                    const obj = JSON.parse(donnees2);  

                    if (obj.erreur != ''){
                        $('.message_erreur_formulaire_admin').empty();
                        $('.message_erreur_formulaire_admin').html(obj.erreur);    
                    }
                    else {
                        $('.message_erreur_formulaire_admin').empty();
                        $('.message_erreur_formulaire_admin').html(obj.message);

                        $('#titre').val('');
                        $('#description').val('');
                        $('#code_formation').val('');
                        $('#condition_formation').val('');
                        $('#metier_vise').val('');
                        $('#frais_scolarite').val('');
                        $('#lieu_formation').val('');
                        $('#duree').val('');
                        $('#niveau_formation').val('');
                        $('#categories').val('');
                        $('input[type="checkbox"]').prop("checked", false);

                    }
                }
            });
        });

        // ici j'affiche la partie formation le formulaire pour modifier 
        $('.corps_admin').on(
            'click',
            '.sous_menu_admin_formation_modifier',
            function(ee)
            {  
                ee.preventDefault();

                let id_form = this.dataset.value; // ici c'est la valeur de mon id
    
                $.ajax({
                    url : 'gestion.php?action=modifier_formation',
                    type: 'post',
                    data : {id_form:id_form},
                    success: function(donnees2){        
    
                        $('.contenu_admin').empty();
                        $('.contenu_admin').append(donnees2);
                        
                        
                    }
                });
        
            })

        // ici j'affiche la partie formation quand on modifie la formation
        $('.corps_admin').on(
            'submit',
            '.valider_formulaire_modif',
            function(e)
            {
                e.preventDefault();
    
                var myForm = document.getElementById('myForm_modif');
    
                let form_data = new FormData(myForm);    
                
                $.ajax({
                    url : 'gestion.php?action=formation_modif',
                    type: 'post',
                    data : form_data,
                    contentType : false,
                    processData : false,
                    success: function(donnees2){        
    
                        const obj = JSON.parse(donnees2);  

                        $('.message_erreur_formulaire_admin').empty();
                        $('.message_erreur_formulaire_admin').html(obj.message);
                    }
                });
        
            });

        // ici j'affiche la partie formation le formulaire pour modifier 
        $('.corps_admin').on(
            'click',
            '.sous_menu_admin_formation_supprimer',
            function(ee)
            {  
                ee.preventDefault();

                let id_form = this.dataset.value; // ici c'est la valeur de mon id
    
                $.ajax({
                    url : 'gestion.php?action=supprimer_confirmer_formation',
                    type: 'post',
                    data : {id_form:id_form},
                    success: function(donnees2){        
    
                        $('.contenu_admin').empty();
                        $('.contenu_admin').append(donnees2);
                        
                        
                    }
                });
        
            })



        // ici on s'occupe de traiter les donnees du formulaire formation
        $('.corps_admin').on(
            'click',
            '.sous_menu_admin_formation_suppr_confirme',
            function(ee)
            {
                ee.preventDefault();

                let id_form = this.dataset.value; // ici c'est la valeur de mon id
        
                $.ajax({
                    url : 'gestion.php?action=supprimer_formation',
                    type: 'post',
                    data : {id_form:id_form},
                    success: function(donnees2){        
        
                        $('.contenu_admin').empty();
                        $('.contenu_admin').append(donnees2);
        
        
                    }
                });
        
            })


        // ici j'affiche la partie competences
        $('.corps_admin').on(
        'click',
        '.sous_menu_admin_competences',
        function(ee)
        {
            ee.preventDefault();
    
            $.ajax({
                url : 'gestion.php?action=competences',
                type: 'post',
                contentType : false,
                processData : false,
                success: function(donnees2){        
    
                    $('.contenu_admin').empty();
                    $('.contenu_admin').append(donnees2);
    
    
                }
            });
    
        })

        // ici j'affiche la partie formation le formulaire pour modifier 
        $('.corps_admin').on(
            'click',
            '.sous_menu_admin_competence_modifier',
            function(ee)
            {  
                ee.preventDefault();

                let id_comp = this.dataset.value; // ici c'est la valeur de mon id

                $.ajax({
                    url : 'gestion.php?action=formulaire_modif_competence',
                    type: 'post',
                    data : {id_comp:id_comp},
                    success: function(donnees2){        
    
                        $('.contenu_admin').empty();
                        $('.contenu_admin').append(donnees2);
                    }
                });
        
            });

        // ici j'affiche la partie competence le formulaire
        $('.corps_admin').on(
        'click',
        '.admin_ajouter_competences',
        function(ee)
        {  
            ee.preventDefault();
    
            $.ajax({
                url : 'gestion.php?action=ajout_competence',
                type: 'post',
                contentType : false,
                processData : false,
                success: function(donnees2){        

                    $('.contenu_admin').empty();
                    $('.contenu_admin').append(donnees2);
    
    
                }
            });
    
        })

        // ici j'affiche la partie compet quand on ajoute la formation
        $('.corps_admin').on(
            'submit',
            '.valider_competence',
            function(e)
            {
                e.preventDefault();
    
                var myForm = document.getElementById('myForm');
    
                let form_data = new FormData(myForm);    
                
                $.ajax({
                    url : 'gestion.php?action=ajouter_competence',
                    type: 'post',
                    data : form_data,
                    contentType : false,
                    processData : false,
                    success: function(donnees2){        
    
                        const obj = JSON.parse(donnees2);
                    
                        if (obj.erreur != ''){
                            $('.message_erreur_formulaire_admin').empty();
                            $('.message_erreur_formulaire_admin').html(obj.erreur);    
                        }
                        else {
                            $('.message_erreur_formulaire_admin').empty();
                            $('.message_erreur_formulaire_admin').html(obj.message);
    
                            $('#titre').val('');
                            $('#description').val('');
                            $('#reference').val('');
                            $('#reference_existe').val('');
                            $('#reference_titre_existe').val('');
                            $('input[type="checkbox"]').prop("checked", false);
    
                        }
                    }
                });
            });


































        // ici j'affiche la partie categorie
        $('.corps_admin').on(
            'click',
            '.sous_menu_admin_categorie',
            function(ee)
            {
                ee.preventDefault();
        
                $.ajax({
                    url : 'gestion.php?action=categories',
                    type: 'post',
                    contentType : false,
                    processData : false,
                    success: function(donnees2){        
        
                        $('.contenu_admin').empty();
                        $('.contenu_admin').append(donnees2);
        
        
                    }
                });
        
            })
            
            // ici j'affiche la partie competence le formulaire
            $('.corps_admin').on(
            'click',
            '.admin_ajouter_categorie',
            function(ee)
            {  
                ee.preventDefault();
        
                $.ajax({
                    url : 'gestion.php?action=ajout_categorie',
                    type: 'post',
                    contentType : false,
                    processData : false,
                    success: function(donnees2){        
    
                        $('.contenu_admin').empty();
                        $('.contenu_admin').append(donnees2);
        
        
                    }
                });
        
            })

             

})



