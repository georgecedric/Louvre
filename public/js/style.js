
  
  
      // Scrollspy fluide
      $(function () {
        $('header a').on('click', function(e) {
          e.preventDefault();
          var hash = this.hash;
          $('html, body').animate({
            scrollTop: $(this.hash).offset().top
          }, 50, function(){
            window.location.hash = hash;
          });
        });
          
      });
        
   

  

$(document).ready(function() {
    $('.js-datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
});



  /* French initialisation for the jQuery UI date picker plugin. */

(function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define([ "../jquery.ui.datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}

(function( datepicker ) {
	datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: 'Précédent',
		nextText: 'Suivant',
		currentText: 'Aujourd\'hui',
		monthNames: ['janvier', 'février', 'mars', 'avril', 'mai', 'juin',
			'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
		monthNamesShort: ['janv.', 'févr.', 'mars', 'avril', 'mai', 'juin',
			'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'],
		dayNames: ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'],
		dayNamesShort: ['dim.', 'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.'],
		dayNamesMin: ['D','L','M','M','J','V','S'],
		weekHeader: 'Sem.',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	datepicker.setDefaults(datepicker.regional['fr']);

	return datepicker.regional['fr'];

}))


 /*    
    *    Get tuesday in a month
    *     @param {Date} dateBegin
    *     @return {Array} selectedDates
    */
    var getTuesday = function(dateBegin){
        var selectedDates     = {};
        if (dateBegin instanceof Date)
        {
            var dateEnd         = new Date(dateBegin.getFullYear(), dateBegin.getMonth() + 1, 1);
            var day             = null;
 
            while (dateBegin <= dateEnd)
            {
                day     = dateBegin.getDay();
                if (day == 2 )
                {
                    selectedDates[dateBegin]        = {};
                    selectedDates[dateBegin][0]     = false;
                    selectedDates[dateBegin][1]     = "";
                    
                }
                dateBegin.setDate(dateBegin.getDate() + 1);
            }
        }
        return selectedDates;
    };
 
 var selectedDates = {};
 
    $( '.js-datepicker' ).datepicker({minDate: 0,
        onChangeMonthYear: function(year, month)
        {
            selectedDates = getTuesday(new Date(year, month - 1, 1));
        },
        beforeShow: function(input, inst){
            var dateNow = new Date();
            selectedDates = getTuesday(new Date(dateNow.getFullYear(), dateNow.getMonth(), 1));
        },
        beforeShowDay: function(date)
           {
              date = new Date(date.getFullYear(), date.getMonth(), date.getDate());
              var highlight     = selectedDates[date];
              if (highlight) {
                return [highlight[0], highlight[1], highlight[2]];
              }
              else {
                 return [true, '', ''];
              }
           }
    });
 

 $(document).ready(function() {
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var ticketRestant = $(".iddata").data("videoid");
    var $container = $('div#louvre_commande_tickets');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;
    
    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.

    
    $('#add_ticket').click(function(e) {
      
      addTicket($container);

      e.preventDefault(); // évite qu'un # apparaisse dans l'URL
      return false;
       
     
    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
    if (index == 0) {
      addTicket($container);
    } else {
      // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
      $container.children('div').each(function() {
        addDeleteLink($(this));
      });
    }


    // La fonction qui ajoute un formulaire CategoryType
    function addTicket($container) {
      
      // Dans le contenu de l'attribut « data-prototype », on remplace :
      // - le texte "__name__label__" qu'il contient par le label du champ
      // - le texte "__name__" qu'il contient par le numéro du champ
      var template = $container.attr('data-prototype')
        .replace(/__name__label__/g, 'Information visiteur n°' + (index+1))
        .replace(/__name__/g,        index)
      ;

      // On crée un objet jquery qui contient ce template
      var $prototype = $(template);

      // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
      addDeleteLink($prototype);

      // On ajoute le prototype modifié à la fin de la balise <div>
      $container.append($prototype);

      // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
      index++;
       
      if (index == ticketRestant){
               $('#add_ticket').off();}
     
    }
    

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {
      // Création du lien
      var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');
      
      // Ajout du lien
      $prototype.append($deleteLink);

      // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
      $deleteLink.click(function(e) {
        var ticketRestant = ticketRestant + 1 ;
        $prototype.remove();
        

        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
      });
    }
  });



// Create a Stripe client.
var stripe = Stripe('pk_test_2I4JpCwyZC6w2hgADFSFnD4r');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}


