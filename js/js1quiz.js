(function() {

  var questions = [];
$.getJSON('../json/quest.json', function (data) {

for (var prop in data) {
    var arr = [];
    for(key in data[prop]){
        arr.push(data[prop][key]);
    }
    questions.push(arr);
}   

});
console.log(questions);
let nbq=questions.length;
console.log(questions.length);


  var questionCounter = 0; //Tracks question number
  var selections=new Array(); //Array containing user choices
  
   for (var i = 0; i < 6; i++) {
     selections[i]= new Array();
   }

  var quiz = $("#quiz"); //Quiz div object

  //Affichage de la premiere question 
  displayNext();

  // Click handler for the 'next' button
  $("#next").on("click", function(e) {
    e.preventDefault();

    // Suspend click listener during fade animation
    if (quiz.is(":animated")) {
      return false;
    }
   choose();
    // 
    // checkBox()==false || testeradio()==false
    //isNaN(selections[questionCounter])
   
    
   console.log(testeradio());
   console.log(checkBox());
   
  var test = document.getElementById(1);
  if (test==null) {
   
    if (testeradio()===false && checkBox()===false) {
      alert("Veuillez faire votre choix");
    } else 
    {
      questionCounter++;
      displayNext();
     }

  }
  else
  {
      console.log(verif());
      console.log(document.getElementById(1).value);
    if (testeradio()===false && checkBox()===false && verif()===false) {
      alert("Veuillez faire votre choix");
    } else 
    {
      questionCounter++;
      displayNext();
     } 
  }
    
  
  });
  

// fonction checkbox verifier 
function checkBox(){
    var checkbox = document.getElementsByName('answer');
    var tr=false;
    for(var i=0; i< checkbox.length; i++) {
        if(checkbox[i].checked) 
          tr=true;
          break; 
    }
  return tr;
}

// fonction radio 
function testeradio() {
    var tr=false;
    var bouton = document.getElementsByName('answer');
  var Nbr = bouton.length;      // Recup du nombre de radio bouton
  for (var i=0; i < Nbr; i++) {      // Parcours les elements
    if (bouton[i].checked == true) {
      tr=true;
      break;
    }
    
  }
  return tr;
}

// fonction qui verifie si l input texte est valide ou non 
function verif(){

if(document.getElementById(1).value ===''){
return false ;

}else 
{
return true;
}
}
  // Click handler for the 'prev' button
  $("#prev").on("click", function(e) {
    e.preventDefault();

    if (quiz.is(":animated")) {
      return false;
    }
    choose();
    questionCounter--;
    displayNext();
  });

  // Click handler for the 'Start Over' button
  $("#start").on("click", function(e) {
    e.preventDefault();

    if (quiz.is(":animated")) {
      return false;
    }
    questionCounter = 0;
    selections = new Array();
     for (var i = 0; i < 5; i++) {
     selections[i]= new Array();
   }
    displayNext();
    $("#start").hide();
  });

  // Animates buttons on hover
  $(".button").on("mouseenter", function() {
    $(this).addClass("active");
  });
  $(".button").on("mouseleave", function() {
    $(this).removeClass("active");
  });


  // Creates and returns the div that contains the questions and
  // the answer selections
  function createQuestionElement(index) {
    var qElement = $("<div>", {
      id: "question"
    });

    var header = $('<h2 style="text-decoration: underline;">Question ' + (index + 1) + " / "+questions.length+":</h2>");
    qElement.append(header);

    var question = $('<p style="margin-top :5%;">').append(questions[index][0]['question']);
    qElement.append(question);

    var score = $('<p style="margin-top :10%;background-color:#F4F4F4;width:15%;margin-left:85%;border :1px solid #51BFD0;">').append(questions[index][0]['score']+' pts');
    qElement.append(score);

    if (questions[index][0]['liste']=="Choix simple") {
    var radioButtons = createRadios(index);
    qElement.append(radioButtons);  
    }
    if (questions[index][0]['liste']=="Choix Multiple") {
    var checkButtons = createCheckbox(index);
    qElement.append(checkButtons);  
    }

    if (questions[index][0]['liste']=="Choix texte") {
      
        var textrep = document.createElement("input");
      textrep.name = "textrep";
      textrep.type = "text";
      textrep.id = 1;
      textrep.style="width:60%; height:30px;margin-left:15%; border-radius: 2px;background-color:#F4F4F4;margin-top:15%;";

      qElement.append(textrep);
    }

    return qElement;
  }

  // Creates a list of the answer choices as radio inputs
  function createRadios(index) {
    var radioList = $('<ul style="margin-top :7%;">');
    var item;
    var input = "";
    for (var i = 0; i < questions[index][0].champs.length; i++) {
      item = $('<li>');
      input = '<input type="radio" name="answer" style="" value=' + i + " />";
      input += questions[index][0].champs[i];
      item.append(input);
      radioList.append(item);
    }

    return radioList;
  }

  // Creates a list of the answer choices as checkbox inputs
  function createCheckbox(index) {
    var radioList = $('<ul style="margin-top :7%;">');
    var item;
    var input = "";
    for (var i = 0; i < questions[index][0].champs.length; i++) {
      item = $('<li style="">');
      input = '<input type="checkbox" name="answer" style="" value=' + i + " />";
      input += '<label><span>'+questions[index][0].champs[i]+'</span></label>';
      item.append(input);
      radioList.append(item);
    }
    return radioList;
  }



  // lis le choix de l utilisateur et le met dans un tableau
  function choose() {
 if (checkBox()===true) {
   var checkbox = document.getElementsByName('answer');
    for (var i = 0; i < checkbox.length; i++) {
      if (checkbox[i].checked===true) {
       selections[questionCounter][i] = i.toString();
      }
    
    }
 }
 else if (testeradio()===true) {
  var bouton = document.getElementsByName('answer');
  var Nbr = bouton.length; 
   for (var i = 0; i < Nbr; i++) {
      if (bouton[i].checked===true) {
       selections[questionCounter][i] = i.toString();
      }
    
    }

 }
 else {
  var j;
    j=0;
    if (document.getElementById(1)!==null) {
     selections[questionCounter][j]=document.getElementById(1).value;
     j++;
    }
    
 }

   
    
  } // fin fonction choose 

  // Displays next requested element
  function displayNext() {
    quiz.fadeOut(function() {
      $("#question").remove();

      if (questionCounter < questions.length) {
        var nextQuestion = createQuestionElement(questionCounter);
        quiz.append(nextQuestion).fadeIn();
        if (!isNaN(selections[questionCounter])) {
          $("input[value=" + selections[questionCounter] + "]").prop(
            "checked",
            true
          );
        }

        // Controls display of 'prev' button
        if (questionCounter === 1) {
          $("#prev").show();
        } else if (questionCounter === 0) {
          $("#prev").hide();
          $("#next").show();
        }
      } else {
        var scoreElem = displayScore();
        quiz.append(scoreElem).fadeIn();
        $("#next").hide();
        $("#prev").hide();
        $("#start").show();
      }
    });
  }

// fonction qui verifie si deux tableaux sont identiques 
function arraysContainSame(a, b) {
  a = Array.isArray(a) ? a : [];
  b = Array.isArray(b) ? b : [];
  return  a.every(el => b.includes(el));
}

  // calcule le score et l afffiche a la fin
  function displayScore() {
    var score = $("<p>", { id: "question" });
    console.log(selections);
    
    var numCorrect = 0;
    var sc=0;

    for (var i = 0; i < selections.length; i++) {
       console.log(selections[i]);
       console.log(questions[i][0].sels);
      if (typeof(questions[i][0].sels)==='undefined') {
             console.log(questions[i][0]['texte']);
             console.log(selections[i][0]);
            let t=0;
          if (questions[i][0]['texte']===selections[i][t]) {

                numCorrect++;
                t++;
                sc+=parseInt(questions[i][0]['score']);
          }

      }
   //(questions[i][0]['texte'])===selections[i][0];
     else {
      if (arraysContainSame(questions[i][0].sels,selections[i])===true ){
        console.log("dougna"); 
               numCorrect++;
               sc+=parseInt(questions[i][0]['score']);
      }
      
         }
    }// fin boucle for 

  // on va stocker le score dans un fichier 
  var obj = { table: [] } ;
  obj.table.push({pnom:'sakhir Fall', score:sc});
 var json = JSON.stringify(obj);

/* var fs = require('../json/joueurscore.json'); 
 fs.writeFile('../json/joueurscore.json', json, 'utf8', callback);*/


  // fin enregistrement 
    score.append(
      "Vous avez trouve " +
        numCorrect +
        " question(s) sur  " +
        questions.length +
        ' et votre score est '+
        sc  
    );
    return score;
  }
})();
