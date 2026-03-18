/**
 * navigation.js — Mobile menu, sticky header, keyboard accessibility
 * @package MyTheme
 */
( function () {
    'use strict';

    const siteHeader = document.getElementById( 'masthead' );
    function handleHeaderScroll() {
        if ( ! siteHeader ) return;
        siteHeader.classList.toggle( 'scrolled', window.scrollY > 20 );
    }
    window.addEventListener( 'scroll', handleHeaderScroll, { passive: true } );
    handleHeaderScroll();

    const menuToggle = document.getElementById( 'menu-toggle' );
    const mainNav    = document.getElementById( 'site-navigation' );
    const body       = document.body;

    if ( menuToggle && mainNav ) {
        menuToggle.addEventListener( 'click', function () {
            const isOpen = mainNav.classList.toggle( 'is-open' );
            menuToggle.classList.toggle( 'active', isOpen );
            menuToggle.setAttribute( 'aria-expanded', isOpen.toString() );
            body.style.overflow = isOpen ? 'hidden' : '';
        } );
        document.addEventListener( 'keydown', function ( e ) {
            if ( e.key === 'Escape' && mainNav.classList.contains( 'is-open' ) ) {
                mainNav.classList.remove( 'is-open' );
                menuToggle.classList.remove( 'active' );
                menuToggle.setAttribute( 'aria-expanded', 'false' );
                body.style.overflow = '';
                menuToggle.focus();
            }
        } );
        document.addEventListener( 'click', function ( e ) {
            if ( mainNav.classList.contains( 'is-open' ) && ! mainNav.contains( e.target ) && ! menuToggle.contains( e.target ) ) {
                mainNav.classList.remove( 'is-open' );
                menuToggle.classList.remove( 'active' );
                menuToggle.setAttribute( 'aria-expanded', 'false' );
                body.style.overflow = '';
            }
        } );
        mainNav.querySelectorAll( 'a' ).forEach( function ( link ) {
            link.addEventListener( 'click', function () {
                mainNav.classList.remove( 'is-open' );
                menuToggle.classList.remove( 'active' );
                menuToggle.setAttribute( 'aria-expanded', 'false' );
                body.style.overflow = '';
            } );
        } );
        window.addEventListener( 'resize', function () {
            if ( window.innerWidth > 768 && mainNav.classList.contains( 'is-open' ) ) {
                mainNav.classList.remove( 'is-open' );
                menuToggle.classList.remove( 'active' );
                menuToggle.setAttribute( 'aria-expanded', 'false' );
                body.style.overflow = '';
            }
        } );
    }
} )();
