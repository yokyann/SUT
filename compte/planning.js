$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
     locale:"fr",
     textColor: 'blue',
     editable:true,
     header:{
      left:'prev,next today',
      center:'title',
      right:'month,agendaWeek,listMonth'
     },
     
 
 
 
     buttonText:{
         today:'Aujourd\'hui',
         month :"Mois",
         agendaWeek: "Semaine",
         agendaDay:"jour",
         listMonth:"Planning",
        
     },
     events: './planning/load.php',
     selectable:true,
     selectHelper:true,
     select: function(start, end, allDay)
     {
      var title = prompt("Entrer un événement");
      if(title)
      {
       var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
       var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
       $.ajax({
        url:"./planning/insert.php",
        type:"POST",
        data:{title:title, start:start, end:end},
        success:function()
        {
         calendar.fullCalendar('refetchEvents');
         alert("Ajouté avec succès");
        }
       })
       pop();
      }
     },
     editable:true,
     eventResize:function(event)
     {
      var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
      var title = event.title;
      var id = event.id;
      $.ajax({
       url:"./planning/update.php",
       type:"POST",
       data:{title:title, start:start, end:end, id:id},
       success:function(){
        calendar.fullCalendar('refetchEvents');
        //alert('Événement mis à jour');
       }
      })
     },
 
     eventDrop:function(event)
     {
      var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
      var title = event.title;
      var id = event.id;
      $.ajax({
       url:"./planning/update.php",
       type:"POST",
       data:{title:title, start:start, end:end, id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        //alert("Événement mis à jour");
       }
      });
     },
 
     eventClick:function(event)
     {
      if(confirm("Êtes-vous sûr.e de vouloir supprimer cet événement?"))
      {
       var id = event.id;
       $.ajax({
        url:"./planning/delete.php",
        type:"POST",
        data:{id:id},
        success:function()
        {
         calendar.fullCalendar('refetchEvents');
         //alert("Événement supprimé");
        }
       })
      }
     },
 
    });
   });

function pop() {
    var popup = document.getElementById("pup");
    popup.classList.toggle("show");
  }
function close(){
    var popup= document.getElementById("pup");
    popup.classList.toggle("hide");
}