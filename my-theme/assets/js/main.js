/**
 * main.js — Smooth scroll, animations, back-to-top, stat counter
 * @package MyTheme
 */
( function () {
    'use strict';

    /* Smooth scroll for anchor links */
    document.querySelectorAll( 'a[href^="#"]' ).forEach( function ( anchor ) {
        anchor.addEventListener( 'click', function ( e ) {
            const targetId = this.getAttribute( 'href' );
            if ( targetId === '#' ) return;
            const target = document.querySelector( targetId );
            if ( ! target ) return;
            e.preventDefault();
            const headerHeight = 115; // TGNE header height
            window.scrollTo( { top: target.getBoundingClientRect().top + window.scrollY - headerHeight - 16, behavior: 'smooth' } );
        } );
    } );

    /* Intersection Observer — fade-in animations */
    if ( 'IntersectionObserver' in window ) {
        const animateEls = document.querySelectorAll( '.feature-card, .testimonial-card, .post-card, .stat-item, .section__header' );
        const styleSheet = document.createElement( 'style' );
        styleSheet.textContent = '.is-visible{opacity:1!important;transform:translateY(0)!important}';
        document.head.appendChild( styleSheet );

        const observer = new IntersectionObserver( function ( entries ) {
            entries.forEach( function ( entry ) {
                if ( entry.isIntersecting ) {
                    entry.target.classList.add( 'is-visible' );
                    observer.unobserve( entry.target );
                }
            } );
        }, { rootMargin: '0px 0px -60px 0px', threshold: 0.1 } );

        animateEls.forEach( function ( el, index ) {
            el.style.opacity         = '0';
            el.style.transform       = 'translateY(24px)';
            el.style.transitionDelay = ( index % 4 ) * 80 + 'ms';
            el.style.transition      = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe( el );
        } );
    }

    /* Back to top button */
    const btn = document.createElement( 'button' );
    btn.className   = 'back-to-top';
    btn.innerHTML   = '<i class="fa-solid fa-chevron-up" aria-hidden="true"></i>';
    btn.setAttribute( 'aria-label', 'Back to top' );
    btn.style.cssText = 'position:fixed;bottom:90px;right:1.5rem;width:44px;height:44px;border-radius:50%;background:var(--lo,#FFA866);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 16px rgba(0,0,0,.2);opacity:0;visibility:hidden;transform:translateY(8px);transition:all 0.25s ease;z-index:2999;font-size:0.875rem;';
    document.body.appendChild( btn );
    window.addEventListener( 'scroll', function () {
        const show = window.scrollY > 400;
        btn.style.opacity    = show ? '1' : '0';
        btn.style.visibility = show ? 'visible' : 'hidden';
        btn.style.transform  = show ? 'translateY(0)' : 'translateY(8px)';
    }, { passive: true } );
    btn.addEventListener( 'click', function () { window.scrollTo( { top: 0, behavior: 'smooth' } ); } );

    /* Stat counter animation */
    function animateCounter( el ) {
        const raw    = el.textContent.trim();
        const suffix = raw.replace( /[0-9]/g, '' );
        const target = parseInt( raw.replace( /\D/g, '' ), 10 );
        if ( isNaN( target ) || target === 0 ) return;
        const start = performance.now();
        const duration = 1800;
        function update( now ) {
            const progress = Math.min( ( now - start ) / duration, 1 );
            const eased    = 1 - Math.pow( 1 - progress, 4 );
            el.textContent = Math.round( eased * target ) + suffix;
            if ( progress < 1 ) requestAnimationFrame( update );
        }
        requestAnimationFrame( update );
    }
    if ( 'IntersectionObserver' in window ) {
        const statObs = new IntersectionObserver( function ( entries ) {
            entries.forEach( function ( entry ) {
                if ( entry.isIntersecting ) { animateCounter( entry.target ); statObs.unobserve( entry.target ); }
            } );
        }, { threshold: 0.5 } );
        document.querySelectorAll( '.stat-item__number' ).forEach( function ( el ) { statObs.observe( el ); } );
    }

    /* External links in content */
    const siteUrl = ( typeof myThemeData !== 'undefined' ) ? myThemeData.siteUrl : window.location.origin;
    document.querySelectorAll( '.entry-content a' ).forEach( function ( link ) {
        const href = link.getAttribute( 'href' );
        if ( href && href.startsWith( 'http' ) && ! href.startsWith( siteUrl ) ) {
            link.setAttribute( 'target', '_blank' );
            link.setAttribute( 'rel', 'noopener noreferrer' );
        }
    } );

} )();
