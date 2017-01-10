/**
 * Created by alex on 29/11/16.
 */
$(document).ready(function() {
    $('select').material_select();

    $( "#chassebundle_user_satisfaction" ).before( '<img id="satisfaction1" src="/img/red-smiley.png" />' );
    $( "#chassebundle_user_satisfaction" ).before( '<img id="satisfaction2" src="/img/lightred-smiley.png" />' );
    $( "#chassebundle_user_satisfaction" ).before( '<img id="satisfaction3" src="/img/lightgren-smiley.png" />' );
    $( "#chassebundle_user_satisfaction" ).before( '<img id="satisfaction4" src="/img/green-smiley.png" />' );
});