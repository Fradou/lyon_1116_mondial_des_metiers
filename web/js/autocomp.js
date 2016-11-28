/**
 * Created by alex on 28/11/16.
 */
$(document).ready( function() {
   /** $('#tags').on('autocompletechange change', function () {
        $('#tagsname').html('You selected: ' + this.value);
    }).change(); **/
   var nbrep = 0;

   $('#tags').change(function () {
       $('#tagsname').html('You selected: ' + this.value);
       nbrep ++;
       $('#nbreponse').html('Il vous reste encore ' + (5- nbrep) + ' reponses à donner');
       $('#tagdisplay').after('<div class="answerchosen">X  ' + $('#tags').val() + '</div>');

   });


   $(document).on('click', '.answerchosen', function() {
       nbrep--;
       $(this).remove();
       $('#nbreponse').html('Il vous reste encore ' + (5- nbrep) + ' reponses à donner');
   });
});

/**
 $('#tags').on('change', function () {
       $('#tagsname').html('You selected: ' + this.value);
       nbrep ++;
       $('#nbreponse').html('Il vous reste encore ' + (5- nbrep) + ' reponses à donner')

   }).change();

 $('#tags').on('autocompleteselect', function (e, ui) {
        $('#tagsname').html('You selected: ' + ui.item.value);
        nbrep ++
    });
 **/