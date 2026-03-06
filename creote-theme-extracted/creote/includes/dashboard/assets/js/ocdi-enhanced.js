jQuery(document).ready(function($) {
    // Only run on OCDI pages
    if (!$('.ocdi').length) return;
    
  
    // Add the dashboard link and import more demos to the header
if ($('.ocdi__title-container').length) {
    // Create a box_button div to contain both links
    var boxButton = $('<div class="box_button"></div>');

    // Create and add the dashboard link if not already present
    if (!$('.ocdi__title-container .dashboard-link').length) {
        var dashboardLink = $('<a href="' + window.location.origin + '/wp-admin" class="dashboard-link">Dashboard</a>');
        boxButton.append(dashboardLink);
    }

    // Create and add the import more demos section
    if ($('.import-more-demos-section').length === 0) {
        var importMoreSection = $('<div class="import-more-demos-section"></div>');
        var importMoreButton = $('<a href="' + window.location.origin + '/wp-admin/admin.php?page=creote&step=demo_import" class="import-more-demos">Import More Demos</a>');
        
        importMoreSection.append(importMoreButton);
        boxButton.append(importMoreSection);

        // Remove the original notice
        $('.notice-success:contains("Import more demos")').remove();
    }

    // Append the box_button to the title container
    $('.ocdi__title-container').append(boxButton);
}
    
    
    // Improve the success screen with a nicer checkmark
    if ($('.ocdi-imported').length) {
        // Add the dashboard link to the imported screen buttons
        if ($('.ocdi-imported-footer').length && !$('.ocdi-imported-footer a[href*="index.php"]').length) {
            $('.ocdi-imported-footer').append('<a href="index.php" class="button">Go to Dashboard</a>');
        }
    }
    
    // Fix for admin menu overlap
    $('#adminmenumain, #wpadminbar, #wpfooter').hide();
    $('#wpcontent').css('margin-left', '0');
});