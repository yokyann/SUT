// $(document).ready(function() {
//     var calendar = $('#calendar').fullCalendar({
//      locale:"fr",
//      textColor: 'blue',
//      editable:true,
//      initialView:'lisMonth',
     
//      events: './planning/load.php',
//      selectable:true,
//      selectHelper:true,
//      select: function(start, end, allDay)
//      {
//       var title = prompt("Entrer un événement");
//       if(title)
//       {
//        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
//        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
//        $.ajax({
//         url:"./planning/insert.php",
//         type:"POST",
//         data:{title:title, start:start, end:end},
//         success:function()
//         {
//          calendar.fullCalendar('refetchEvents');
//          alert("Ajouté avec succès");
//         }
//        })
//        pop();
//       }
//      },
//      editable:true,
//      eventResize:function(event)
//      {
//       var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
//       var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
//       var title = event.title;
//       var id = event.id;
//       $.ajax({
//        url:"./planning/update.php",
//        type:"POST",
//        data:{title:title, start:start, end:end, id:id},
//        success:function(){
//         calendar.fullCalendar('refetchEvents');
//         //alert('Événement mis à jour');
//        }
//       })
//      },
 
//      eventDrop:function(event)
//      {
//       var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
//       var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
//       var title = event.title;
//       var id = event.id;
//       $.ajax({
//        url:"./planning/update.php",
//        type:"POST",
//        data:{title:title, start:start, end:end, id:id},
//        success:function()
//        {
//         calendar.fullCalendar('refetchEvents');
//         //alert("Événement mis à jour");
//        }
//       });
//      },
 
//      eventClick:function(event)
//      {
//       if(confirm("Êtes-vous sûr.e de vouloir supprimer cet événement?"))
//       {
//        var id = event.id;
//        $.ajax({
//         url:"./planning/delete.php",
//         type:"POST",
//         data:{id:id},
//         success:function()
//         {
//          calendar.fullCalendar('refetchEvents');
//          //alert("Événement supprimé");
//         }
//        })
//       }
//      },
 
//     });
//    });

function pop() {
    var popup = document.getElementById("pup");
    popup.classList.toggle("show");
  }
function close(){
    var popup= document.getElementById("pup");
    popup.classList.toggle("hide");
}

window.onload = () => {
    let elementCalendrier = document.getElementById("calendar")

   

                // On instancie le calendrier
                let calendrier = new FullCalendar.Calendar(elementCalendrier, {
                    // On appelle les composants
                    plugins: ['dayGrid','timeGrid','list','interaction'],
                   defaultView: 'listMonth',
                     locale: 'fr',
                     header: {
                       left: 'prev,next today',
                        center: 'évenements',
                        right:'title'
                     },
                    // buttonText: {
                    //     today: 'Aujourd\'hui',
                    //     month: 'Mois',
                    //     week: 'Semaine',
                    //     list: 'Liste'
                    // },
                    // events: evenements,
                    // nowIndicator: true,
                    // editable: true,
                    // eventDrop: (infos) => {
                    //     if(!confirm("Etes vous sûr.e de vouloir déplacer cet évènement")){
                    //         infos.revert();
                    //     }
                    // },
                    // eventResize: (infos) => {
                    //     console.log(infos.event.end)
                    // }

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
                })

                calendrier.render()


            }
