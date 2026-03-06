/**
 * creote Enhanced Dashboard JavaScript
 * Enhanced interactive functionality for the theme setup wizard with page builder selection
 */

jQuery(document).ready(function($) {
    'use strict';
    
    // Configuration object for the setup wizard
    var themeSetupConfig = {
        logo: '/includes/admin/dashboard/assets/img/steellogo.png',
        ajax_url: ajaxurl,
        nonce: theme_setup_wizard ? theme_setup_wizard.nonce : '',
        texts: {
            installing: 'Installing...',
            installed: 'Installed',
            activating: 'Activating...',
            activated: 'Activated',
            error: 'Error',
            success: 'Success',
            tryAgain: 'Try Again'
        }
    };

    // Initialize the wizard
    initSetupWizard();

    /**
     * Initialize the main setup wizard functionality
     */
    function initSetupWizard() {
        // Add the app container class to the body for styling
        $('body').addClass('creote-app-container');
         
        // Add logo to the header if it doesn't exist
        if ($('.wizard-header-logo').length === 0) {
            $('.wizard-header h1').wrap('<div class="wizard-header-logo"></div>');
            $('.wizard-header-logo').prepend('<div class="theme-logo"><img src="' + themeSetupConfig.logo + '" alt="creote Theme"></div>');
        }
        
        // Create stats cards in the welcome step
        if ($('.wizard-step-content.welcome_content').length > 0) {
            createStatsCards();
        }
        
        // Initialize page builder selection
        initPageBuilderSelection();
        
        // Initialize the server capability check panel
        initServerCapabilityCheck();
        
        // Initialize child theme installation
        initChildThemeInstallation();
        
        // Initialize plugin installation
        initPluginInstallation();
        
        // Initialize demo import
        initDemoImport();
    }

    /**
     * Initialize page builder selection functionality
     */
    function initPageBuilderSelection() {
        // Handle page builder option selection
        $('.page-builder-option input[type="radio"]').on('change', function() {
            // Remove selected class from all options
            $('.page-builder-option').removeClass('selected');
            
            // Add selected class to the chosen option
            $(this).closest('.page-builder-option').addClass('selected');
            
            // Update the form button text
            var selectedBuilder = $(this).val();
            var builderName = selectedBuilder === 'elementor' ? 'Elementor' : 'WPBakery Page Builder';
            $('.page-builder-form .button-primary').html(
                'Continue with ' + builderName + ' <span class="dashicons dashicons-arrow-right-alt"></span>'
            );
        });

        // Handle clicking on the entire card
        $('.page-builder-card').on('click', function(e) {
            e.preventDefault();
            var radio = $(this).siblings('input[type="radio"]');
            radio.prop('checked', true).trigger('change');
        });

        // Add hover effects to page builder cards
        $('.page-builder-option').hover(
            function() {
                if (!$(this).hasClass('selected')) {
                    $(this).find('.page-builder-card').addClass('hover');
                }
            },
            function() {
                $(this).find('.page-builder-card').removeClass('hover');
            }
        );

        // Initialize the selected state based on the checked radio button
        $('.page-builder-option input[type="radio"]:checked').trigger('change');

        // Handle form submission
        $('.page-builder-form').on('submit', function(e) {
            var selectedBuilder = $('input[name="page_builder"]:checked').val();
            
            if (!selectedBuilder) {
                e.preventDefault();
                showNotification('warning', 'Please select a page builder before continuing.');
                return false;
            }

            // Show loading state
            var submitBtn = $(this).find('.button-primary');
            submitBtn.prop('disabled', true);
            submitBtn.html('<span class="dashicons dashicons-update spin"></span> Saving Selection...');
        });
    }

    /**
     * Create statistics cards for the welcome step
     */
    function createStatsCards() {
        // Only create if they don't already exist
        if ($('.stats-card-row').length === 0) {
            var statsCardRow = $('<div class="stats-card-row"></div>');
            
            // Create server status card
            var serverStatus = getServerStatusInfo();
            var serverStatusCard = createStatsCard(
                'Server Status', 
                serverStatus.label, 
                serverStatus.icon, 
                serverStatus.color, 
                ''
            );
            
            // Create PHP version card
            var phpVersion = $('td:contains("PHP Version")').next().text();
            var phpCard = createStatsCard(
                'PHP Version', 
                phpVersion || '7.4+', 
                '', 
                '', 
                'Current version'
            );
            
            // Create memory limit card
            var memoryLimit = $('td:contains("Memory Limit")').next().text();
            var memoryCard = createStatsCard(
                'Memory Limit', 
                memoryLimit || '256MB', 
                '', 
                '', 
                'Available memory'
            );
            
            // Create execution time card
            var execTime = $('td:contains("Max Execution Time")').next().text();
            var execTimeCard = createStatsCard(
                'Execution Time', 
                execTime || '300 sec', 
                '', 
                '', 
                'Script timeout'
            );
            
            // Add cards to the row
            statsCardRow.append(serverStatusCard, phpCard, memoryCard, execTimeCard);
            
            // Add the row to the welcome content
            $('.wizard-step-content.welcome_content').prepend(statsCardRow);
        }
    }

    /**
     * Get server status information
     */
    function getServerStatusInfo() {
        var criticalIssues = $('.critical-issues').length > 0;
        var warnings = $('.status-warning').length > 0;
        
        if (criticalIssues) {
            return {
                label: 'Issues Found',
                icon: 'dashicons-warning',
                color: 'var(--danger-color)'
            };
        } else if (warnings) {
            return {
                label: 'Warnings',
                icon: 'dashicons-warning',
                color: 'var(--warning-color)'
            };
        } else {
            return {
                label: 'Ready',
                icon: 'dashicons-yes-alt',
                color: 'var(--success-color)'
            };
        }
    }

    /**
     * Create a stats card element
     */
    function createStatsCard(title, value, icon, iconColor, subtitle) {
        var card = $('<div class="stats-card"></div>');
        var titleHtml = title ? '<h4 class="stats-card-title">' + title + '</h4>' : '';
        var iconHtml = icon ? '<span class="dashicons ' + icon + '" style="color: ' + iconColor + '"></span>' : '';
        var valueHtml = '<h3 class="stats-card-value">' + iconHtml + value + '</h3>';
        var subtitleHtml = subtitle ? '<div class="stats-card-meta"><span class="stats-card-period">' + subtitle + '</span></div>' : '';
        
        card.append(titleHtml, valueHtml, subtitleHtml);
        return card;
    }

    /**
     * Initialize server capability check refresh functionality
     */
    function initServerCapabilityCheck() {
        $("#refresh-server-check").on("click", function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var originalText = $button.html();
            
            // Disable button and show loading state
            $button.html('<span class="dashicons dashicons-update spin"></span> ' + 'Refreshing...');
            $button.prop("disabled", true);
            
            // Send AJAX request to refresh server check
            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    action: "refresh_server_check",
                    nonce: creote_server_check.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message and reload after a delay
                        $button.html('<span class="dashicons dashicons-yes"></span> Updated!');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        // Show error message
                        $button.html(originalText);
                        $button.prop("disabled", false);
                        showNotification('error', response.data.message || "An error occurred");
                    }
                },
                error: function() {
                    // Show generic error message
                    $button.html(originalText);
                    $button.prop("disabled", false);
                    showNotification('error', "Connection error");
                }
            });
        });
    }

    /**
     * Initialize child theme installation
     */
    function initChildThemeInstallation() {
        $('input[name="install_child_theme"]').on('change', function() {
            if ($(this).is(':checked')) {
                var installButton = $('<button>', {
                    type: 'button',
                    class: 'button button-primary install-child-theme',
                    text: 'Install Child Theme Now'
                });
                
                if ($('.install-child-theme').length === 0) {
                    $('#child_theme_status').append(installButton);
                }
            } else {
                $('.install-child-theme').remove();
            }
        });

        // Trigger the change event to initialize the UI
        $('input[name="install_child_theme"]').trigger('change');
        
        // Child theme installation AJAX handler
        $(document).on('click', '.install-child-theme', function() {
            var button = $(this);
            var status = $('#child_theme_status');
            
            button.prop('disabled', true).text('Installing...');
            status.append('<p class="installing">Installing child theme...</p>');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'install_child_theme',
                    nonce: theme_setup_wizard.nonce
                },
                success: function(response) {
                    status.find('.installing').remove();
                    if (response.success) {
                        button.text('Installed').addClass('button-disabled');
                        status.append('<p class="success">' + response.data.message + '</p>');
                        
                        // Replace child-theme-option with success message
                        setTimeout(function() {
                            $('.child-theme-option').replaceWith(
                                '<div class="notice notice-success">' +
                                '<p>Child theme is now installed and active.</p>' +
                                '</div>'
                            );
                        }, 1000);
                        
                        // Show success notification
                        showNotification('success', 'Child theme installed successfully');
                    } else {
                        button.prop('disabled', false).text('Try Again');
                        status.append('<p class="error">' + response.data.message + '</p>');
                        showNotification('error', response.data.message);
                    }
                },
                error: function() {
                    status.find('.installing').remove();
                    button.prop('disabled', false).text('Try Again');
                    status.append('<p class="error">Connection error. Please try again.</p>');
                    showNotification('error', 'Connection error. Please try again.');
                }
            });
        });
        
        // Child theme activation AJAX handler
        $(document).on('click', '.activate-child-theme', function() {
            var button = $(this);
            var themeSlug = button.data('theme');
            
            button.prop('disabled', true).text('Activating...');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'activate_child_theme',
                    nonce: theme_setup_wizard.nonce,
                    theme: themeSlug
                },
                success: function(response) {
                    if (response.success) {
                        button.text('Activated').addClass('button-disabled');
                        
                        // Replace notice with success message
                        setTimeout(function() {
                            button.closest('.notice').replaceWith(
                                '<div class="notice notice-success">' +
                                '<p>Child theme is now activated successfully.</p>' +
                                '</div>'
                            );
                            
                            showNotification('success', 'Child theme activated');
                        }, 1000);
                    } else {
                        button.prop('disabled', false).text('Try Again');
                        button.after('<p class="error">' + response.data.message + '</p>');
                        showNotification('error', response.data.message);
                    }
                },
                error: function() {
                    button.prop('disabled', false).text('Try Again');
                    button.after('<p class="error">Connection error. Please try again.</p>');
                    showNotification('error', 'Connection error');
                }
            });
        });
    }

    /**
     * Initialize plugin installation with page builder awareness
     */
    function initPluginInstallation() {
        var pluginQueue = [];
        var currentPluginIndex = 0;
        var isInstalling = false;
        
        // Select all plugins checkbox
        $('#select-all-plugins').on('change', function() {
            var isChecked = $(this).prop('checked');
            $('.plugin-checkbox:not(:disabled)').prop('checked', isChecked);
        });

        // Individual plugin installation/activation/deactivation
        $('.install-plugin, .activate-plugin, .deactivate-plugin').on('click', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var action = button.data('action');
            var pluginRow = button.closest('tr');
            var slug = pluginRow.data('plugin-slug');
            var source = pluginRow.data('plugin-source');
            var path = pluginRow.data('plugin-path');
            
            // Disable button during operation
            button.prop('disabled', true);
            
            if (action === 'install') {
                installPlugin(button, slug, source, path);
            } else if (action === 'activate') {
                activatePlugin(button, slug, path);
            } else if (action === 'deactivate') {
                deactivatePlugin(button, slug, path);
            }
        });
        
        // Install selected plugins
        $('.install-selected-plugins').on('click', function(e) {
            e.preventDefault();
            
            var button = $(this);
            
            // Check if any non-required plugins are selected
            var hasSelection = false;
            $('.plugin-checkbox:not(:disabled)').each(function() {
                if ($(this).is(':checked')) {
                    hasSelection = true;
                    return false; // Break the loop
                }
            });
            
            // Show notification if nothing selected
            if (!hasSelection) {
                showNotification('warning', 'Please select at least one plugin first');
                $('.plugin-installation-progress').html('<div class="notice notice-warning"><p>Please select at least one plugin to install or activate.</p></div>');
                return;
            }
            
            button.prop('disabled', true);
            button.text('Processing...');
            
            // Build plugin queue with selected plugins
            pluginQueue = [];
            $('.plugin-checkbox:checked').each(function() {
                var row = $(this).closest('tr');
                var slug = row.data('plugin-slug');
                var source = row.data('plugin-source');
                var path = row.data('plugin-path');
                var status = row.find('.plugin-status').attr('class') || '';
                status = status.replace('plugin-status ', '');
                
                pluginQueue.push({
                    row: row,
                    slug: slug,
                    source: source,
                    path: path,
                    status: status
                });
            });
            
            // Start processing queue
            currentPluginIndex = 0;
            processPluginQueue();
        });
        
        // Deactivate selected plugins
        $('.deactivate-selected-plugins').on('click', function(e) {
            e.preventDefault();
            
            var button = $(this);
            
            // Check if any plugins are selected at all
            var anySelected = $('.plugin-checkbox:checked').length > 0;
            
            if (!anySelected) {
                showNotification('warning', 'Please select at least one plugin first');
                $('.plugin-installation-progress').html('<div class="notice notice-warning"><p>Please select at least one plugin to deactivate.</p></div>');
                return;
            }
            
            button.prop('disabled', true);
            button.text('Processing...');
            
            // Build plugin queue with selected plugins that are active
            var deactivateQueue = [];
            $('.plugin-checkbox:checked').each(function() {
                var row = $(this).closest('tr');
                var slug = row.data('plugin-slug');
                var path = row.data('plugin-path');
                var status = row.find('.plugin-status').attr('class') || '';
                status = status.replace('plugin-status ', '');
                var isRequired = $(this).data('required') === 1;
                
                // Only add active and non-required plugins to the deactivation queue
                if (status === 'active' && !isRequired) {
                    deactivateQueue.push({
                        row: row,
                        slug: slug,
                        path: path
                    });
                }
            });
            
            if (deactivateQueue.length === 0) {
                showNotification('warning', 'No active non-required plugins selected');
                $('.plugin-installation-progress').html('<div class="notice notice-warning"><p>None of the selected plugins can be deactivated. Please note that required plugins cannot be deactivated.</p></div>');
                button.prop('disabled', false);
                button.text('Deactivate Selected');
                return;
            }
            
            // Process deactivation queue
            processDeactivationQueue(deactivateQueue, 0, button);
        });
        
        // Process plugin queue one by one
        function processPluginQueue() {
            if (currentPluginIndex >= pluginQueue.length) {
                // Queue completed
                $('.install-selected-plugins').text('All Plugins Installed & Activated');
                $('.plugin-installation-progress').html('<div class="notice notice-success"><p>All selected plugins have been installed and activated successfully.</p></div>');
                
                // Enable next button
                $('.next-step').prop('disabled', false).attr('href', function() {
                    return $(this).attr('href') + '&plugins_installed=true';
                });
                
                showNotification('success', 'All plugins processed successfully');
                
                // Reset the button after 3 seconds
                setTimeout(function() {
                    $('.install-selected-plugins').prop('disabled', false).text('Install & Activate Selected');
                }, 3000);
                
                return;
            }
            
            var plugin = pluginQueue[currentPluginIndex];
            var row = plugin.row;
            var button = row.find('button');
            
            // Update progress message
            $('.plugin-installation-progress').html(
                '<div class="notice notice-info">' +
                '<p>Processing: <strong>' + plugin.slug + '</strong> (' + (currentPluginIndex + 1) + ' of ' + pluginQueue.length + ')</p>' +
                '<div class="progress-bar-container"><div class="progress-bar" style="width: ' + 
                Math.round((currentPluginIndex / pluginQueue.length) * 100) + '%"></div></div>' +
                '</div>'
            );
            
            // Safely get plugin status
            var status = plugin.status;
            
            if (status === 'not-installed' || status === '') {
                // Install and then activate
                installPlugin(button, plugin.slug, plugin.source, plugin.path, function() {
                    activatePlugin(button, plugin.slug, plugin.path, function() {
                        currentPluginIndex++;
                        processPluginQueue();
                    });
                });
            } else if (status === 'inactive') {
                // Just activate
                activatePlugin(button, plugin.slug, plugin.path, function() {
                    currentPluginIndex++;
                    processPluginQueue();
                });
            } else {
                // Skip already active plugins
                currentPluginIndex++;
                processPluginQueue();
            }
        }
        
        // Process deactivation queue one by one
        function processDeactivationQueue(queue, index, mainButton) {
            if (index >= queue.length) {
                // Queue completed
                mainButton.text('Plugins Deactivated');
                $('.plugin-installation-progress').html('<div class="notice notice-success"><p>Selected plugins have been deactivated successfully.</p></div>');
                
                setTimeout(function() {
                    mainButton.prop('disabled', false);
                    mainButton.text('Deactivate Selected');
                }, 2000);
                
                showNotification('success', 'All plugins deactivated successfully');
                return;
            }
            
            var plugin = queue[index];
            var row = plugin.row;
            var button = row.find('button');
            
            // Update progress message
            $('.plugin-installation-progress').html(
                '<div class="notice notice-info">' +
                '<p>Deactivating: <strong>' + plugin.slug + '</strong> (' + (index + 1) + ' of ' + queue.length + ')</p>' +
                '<div class="progress-bar-container"><div class="progress-bar" style="width: ' + 
                Math.round((index / queue.length) * 100) + '%"></div></div>' +
                '</div>'
            );
            
            // Deactivate the plugin
            deactivatePlugin(button, plugin.slug, plugin.path, function() {
                // Move to next plugin
                index++;
                processDeactivationQueue(queue, index, mainButton);
            });
        }
        
        // Install plugin function with error handling
        function installPlugin(button, slug, source, path, callback) {
            button.text(theme_setup_wizard.plugin_texts.installing);
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'install_plugin',
                    nonce: theme_setup_wizard.nonce,
                    slug: slug,
                    source: source
                },
                success: function(response) {
                    if (response.success) {
                        // Update the button to bcreotee an activation button
                        button.text(theme_setup_wizard.plugin_texts.installed);
                        button.data('action', 'activate');
                        button.removeClass('install-plugin').addClass('activate-plugin');
                        button.prop('disabled', false);  // Enable the button for activation
                        
                        // Update status in the row
                        button.closest('tr').find('.plugin-status')
                            .removeClass('not-installed')
                            .addClass('inactive')
                            .text('Installed');
                        
                        // If this is part of a queue, continue with activation
                        if (typeof callback === 'function') {
                            callback();
                        } else {
                            // If clicked individually, prompt user to activate
                            button.text('Activate');
                            showNotification('success', slug + ' installed successfully');
                        }
                    } else {
                        handlePluginError(button, slug, 'installation', response.data ? response.data.message : null, callback);
                    }
                },
                error: function(xhr, status, error) {
                    handlePluginError(button, slug, 'installation', error, callback);
                }
            });
        }
        
        // Activate plugin function with error handling
        function activatePlugin(button, slug, path, callback) {
            button.text(theme_setup_wizard.plugin_texts.activating);
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'activate_plugin',
                    nonce: theme_setup_wizard.nonce,
                    slug: slug,
                    path: path
                },
                success: function(response) {
                    if (response.success) {
                        // Update status in the row
                        button.closest('tr').find('.plugin-status')
                            .removeClass('inactive')
                            .addClass('active')
                            .text('Active');
                        
                        // Check if plugin is required
                        var isRequired = button.closest('tr').find('.plugin-checkbox').data('required') === 1;
                        
                        if (isRequired) {
                            // Replace button with text for required plugins
                            button.replaceWith('<span class="plugin-status-text">Active (Required)</span>');
                        } else {
                            // Replace with deactivate button for non-required plugins
                            var deactivateButton = $('<button class="button deactivate-plugin" data-action="deactivate">Deactivate</button>');
                            button.replaceWith(deactivateButton);
                            
                            // Re-attach event handler to the new button
                            deactivateButton.on('click', function(e) {
                                e.preventDefault();
                                var btn = $(this);
                                var row = btn.closest('tr');
                                var s = row.data('plugin-slug');
                                var p = row.data('plugin-path');
                                btn.prop('disabled', true);
                                deactivatePlugin(btn, s, p);
                            });
                        }
                        
                        if (typeof callback === 'function') {
                            callback();
                        } else {
                            showNotification('success', slug + ' activated successfully');
                        }
                    } else {
                        handlePluginError(button, slug, 'activation', response.data ? response.data.message : null, callback);
                    }
                },
                error: function(xhr, status, error) {
                    handlePluginError(button, slug, 'activation', error, callback);
                }
            });
        }
        
        // Deactivate plugin function with error handling
        function deactivatePlugin(button, slug, path, callback) {
            button.text(theme_setup_wizard.plugin_texts.deactivating);
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'deactivate_plugin',
                    nonce: theme_setup_wizard.nonce,
                    slug: slug,
                    path: path
                },
                success: function(response) {
                    if (response.success) {
                        // Update status in the row
                        button.closest('tr').find('.plugin-status')
                            .removeClass('active')
                            .addClass('inactive')
                            .text('Installed');
                        
                        // Replace with activate button
                        var activateButton = $('<button class="button activate-plugin" data-action="activate">Activate</button>');
                        button.replaceWith(activateButton);
                        
                        // Re-attach event handler to the new button
                        activateButton.on('click', function(e) {
                            e.preventDefault();
                            var btn = $(this);
                            var row = btn.closest('tr');
                            var s = row.data('plugin-slug');
                            var p = row.data('plugin-path');
                            btn.prop('disabled', true);
                            activatePlugin(btn, s, p);
                        });
                        
                        if (typeof callback === 'function') {
                            callback();
                        } else {
                            showNotification('success', slug + ' deactivated successfully');
                        }
                    } else {
                        handlePluginError(button, slug, 'deactivation', response.data ? response.data.message : null, callback);
                    }
                },
                error: function(xhr, status, error) {
                    handlePluginError(button, slug, 'deactivation', error, callback);
                }
            });
        }
        
        // Helper function to handle plugin errors but continue with queue
        function handlePluginError(button, slug, operation, errorMessage, callback) {
            console.error('Plugin ' + operation + ' failed for ' + slug + ':', errorMessage);
            
            // Show error in UI but in a non-blocking way
            var errorNotice = '<div class="notice notice-error inline"><p>' + 
                'Failed to ' + operation + ' ' + slug + 
                (errorMessage ? ': ' + errorMessage : '') + 
                '</p></div>';
                
            $('.plugin-installation-progress').append(errorNotice);
            
            // Reset button state
            if (operation === 'installation') {
                button.text(theme_setup_wizard.plugin_texts.install_failed);
                button.prop('disabled', false);
            } else if (operation === 'activation') {
                button.text(theme_setup_wizard.plugin_texts.activation_failed);
                button.prop('disabled', false);
            } else if (operation === 'deactivation') {
                button.text(theme_setup_wizard.plugin_texts.deactivation_failed);
                button.prop('disabled', false);
            }
            
            // Show notification
            showNotification('error', 'Failed to ' + operation + ' ' + slug);
            
            // Continue with next plugin instead of stopping the entire process
            if (typeof callback === 'function') {
                callback();
            }
        }
    }

    /**
     * Initialize demo import
     */
    function initDemoImport() {
        // Enhance demo items with hover effects
        $('.demo-item').hover(
            function() {
                $(this).find('.demo-actions').fadeIn(200);
            },
            function() {
                $(this).find('.demo-actions').fadeOut(200);
            }
        );
        
        // Handle import demo button click
        $('.import-demo-button').on('click', function(e) {
            // No need to prevent default as we want to navigate to OCDI page
            // Just add loading state
            var button = $(this);
            button.addClass('button-loading');
            button.text('Preparing...');
        });
        
        // Add progress indicator for demo import step
        if ($('.wizard-step-content:contains("Demo Content Import")').length > 0 && $('.progress-indicator').length === 0) {
            var progressIndicator = createProgressIndicator();
            $('.wizard-step-content:contains("Demo Content Import")').prepend(progressIndicator);
        }
    }
    
    /**
     * Create a progress indicator element for demo import
     */
    function createProgressIndicator() {
        var progressIndicator = $('<div class="progress-indicator"></div>');
        
        var steps = [
            { id: 'check', label: 'Server Check', completed: true },
            { id: 'builder', label: 'Page Builder', completed: true },
            { id: 'plugins', label: 'Install Plugins', completed: true },
            { id: 'prepare', label: 'Prepare Import', completed: false, active: true },
            { id: 'import', label: 'Import Content', completed: false },
            { id: 'finish', label: 'Finalize Setup', completed: false }
        ];
        
        $.each(steps, function(index, step) {
            var stepClass = step.completed ? 'completed' : (step.active ? 'active' : '');
            var iconClass = step.completed ? 'dashicons-yes-alt' : (step.active ? 'dashicons-arrow-right-alt' : 'dashicons-marker');
            
            var stepElement = $('<div class="progress-step ' + stepClass + '" data-step="' + step.id + '"></div>');
            var iconElement = $('<div class="progress-step-icon"><span class="dashicons ' + iconClass + '"></span></div>');
            var labelElement = $('<div class="progress-step-label">' + step.label + '</div>');
            
            stepElement.append(iconElement, labelElement);
            progressIndicator.append(stepElement);
        });
        
        return progressIndicator;
    }
    
    /**
     * Show notification
     */
    function showNotification(type, message) {
        // Remove any existing notifications
        $('.wizard-notification').remove();
        
        var icon = type === 'success' ? 'dashicons-yes-alt' : 'dashicons-warning';
        var notificationClass = 'wizard-notification notification-' + type;
        
        var notification = $(
            '<div class="' + notificationClass + '">' +
            '<span class="dashicons ' + icon + '"></span>' +
            '<span class="notification-message">' + message + '</span>' +
            '<span class="dashicons dashicons-no-alt notification-close"></span>' +
            '</div>'
        );
        
        $('body').append(notification);
        
        // Show with animation
        setTimeout(function() {
            notification.addClass('show');
        }, 10);
        
        // Auto hide after 4 seconds
        setTimeout(function() {
            notification.removeClass('show');
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 4000);
        
        // Close button
        notification.find('.notification-close').on('click', function() {
            notification.removeClass('show');
            setTimeout(function() {
                notification.remove();
            }, 300);
        });
    }
    
    // Add CSS for page builder selection and notifications
    $("<style>")
        .prop("type", "text/css")
        .html("\
        /* Page Builder Selection Styles */\
        .page-builder-card.hover {\
            border-color: #0073aa !important;\
            transform: translateY(-1px);\
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);\
        }\
        \
        .page-builder-form .button-primary.loading {\
            pointer-events: none;\
        }\
        \
        .page-builder-form .spin {\
            animation: spin 1s linear infinite;\
        }\
        \
        @keyframes spin {\
            0% { transform: rotate(0deg); }\
            100% { transform: rotate(360deg); }\
        }\
        \
        /* Deactivate Plugin Styles */\
        .deactivate-plugin {\
            background-color: #f1f1f1;\
            border-color: #ccc;\
            color: #555;\
        }\
        .deactivate-plugin:hover {\
            background-color: #e5e5e5;\
            border-color: #aaa;\
            color: #333;\
        }\
        .deactivate-selected-plugins {\
            margin-left: 10px;\
        }\
        .plugin-status-text {\
            display: inline-block;\
            padding: 4px 8px;\
            color: #666;\
        }\
        \
        /* Notification Styles */\
        .wizard-notification {\
            position: fixed;\
            top: 20px;\
            right: 20px;\
            padding: 15px 20px;\
            border-radius: 4px;\
            display: flex;\
            align-items: center;\
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);\
            z-index: 99999;\
            transform: translateX(120%);\
            transition: transform 0.3s ease;\
            background: white;\
            color: var(--text-dark);\
            max-width: 300px;\
        }\
        .wizard-notification.show {\
            transform: translateX(0);\
        }\
        .notification-success {\
            border-left: 4px solid var(--success-color);\
        }\
        .notification-error {\
            border-left: 4px solid var(--danger-color);\
        }\
        .notification-warning {\
            border-left: 4px solid var(--warning-color);\
        }\
        .wizard-notification .dashicons {\
            margin-right: 10px;\
            font-size: 20px;\
        }\
        .notification-success .dashicons:first-child {\
            color: var(--success-color);\
        }\
        .notification-error .dashicons:first-child {\
            color: var(--danger-color);\
        }\
        .notification-warning .dashicons:first-child {\
            color: var(--warning-color);\
        }\
        .notification-message {\
            flex: 1;\
            margin-right: 10px;\
        }\
        .notification-close {\
            cursor: pointer;\
            color: var(--text-light);\
        }\
        .notification-close:hover {\
            color: var(--text-dark);\
        }\
        ")
        .appendTo("head");
});

// When DOM is ready on the admin page for duplicates cleanup
jQuery(document).ready(function($) {
    // Initialize form submission for duplicate cleanup
    if ($('.duplicatecleaner form').length > 0) {
        $('.duplicatecleaner form').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var submitButton = form.find('input[type="submit"]');
            var originalText = submitButton.val();
            
            // Show loading state
            submitButton.val('Cleaning up...').prop('disabled', true);
            
            // Get form data properly including the nonce
            var formData = new FormData(form[0]);
            
            // Add the WordPress action
            formData.append('action', 'cleanup_duplicates_action');
            
            // Submit the form via AJAX
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Show success message
                    if (response.success) {
                        var message = 'Cleanup completed. ' + 
                            (response.data && response.data.count ? response.data.count : '0') + 
                            ' post duplicates and ' + 
                            (response.data && response.data.media_count ? response.data.media_count : '0') + 
                            ' media duplicates removed.';
                            
                        $('.resultcleanup').remove();
                        form.before('<div class="resultcleanup  notice-success"><p>' + message + '</p></div>');
                    } else {
                        form.before('<div class="resultcleanup  notice-error"><p>Error during cleanup: ' + 
                            (response.data && response.data.message ? response.data.message : 'Unknown error') + 
                            '</p></div>');
                    }
                    
                    // Reset button
                    submitButton.val(originalText).prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    // Show error message with details
                    form.before('<div class="resultcleanup notice notice-error"><p>An error occurred during cleanup. ' + 
                        'Status: ' + status + ', Error: ' + error + '</p></div>');
                    
                    // Reset button
                    submitButton.val(originalText).prop('disabled', false);
                }
            });
        });
    }
});