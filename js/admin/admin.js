

/*
------------------
Hide submenus
https://www.codeply.com/go/LFd2SEMECH
-------------------
*/
$('#body-row .collapse').collapse('hide'); 

// Collapse/Expand icon
$('#collapse-icon').addClass('fa-angle-double-left'); 

// Collapse click
$('[data-toggle=sidebar-colapse]').click(function() {
    SidebarCollapse();
});

function SidebarCollapse () {
    $('.menu-collapsed').toggleClass('d-none');
    $('.sidebar-submenu').toggleClass('d-none');
    $('.submenu-icon').toggleClass('d-none');
    $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');
	
    
    // Treating d-flex/d-none on separators with title
    var SeparatorTitle = $('.sidebar-separator-title');
    if ( SeparatorTitle.hasClass('d-flex') ) {
        SeparatorTitle.removeClass('d-flex');
    } else {
        SeparatorTitle.addClass('d-flex');
    }
    
    // Collapse/Expand icon
    $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right');
}



//* NEWSLETTER *//
$(document).ready( function() {
	
	//Select all
	$( "#select_all_cats" ).click(function(event) {
		event.preventDefault();
		
		var options = document.getElementById("nl_users_cats");
    	for ( i=0; i<options.length; i++)
    	{
    		options[i].selected = "true";
    	}
		

		return false;
	});
	
});
		