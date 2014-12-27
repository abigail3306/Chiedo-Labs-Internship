jQuery(document).ready(function() {
  // Scripts. Encapsulated in an anonymous function to avoid conflicts. 
  (function($) {
    /*
    GLOBAL VARIABLES
    */
    cs.variableName = ""; 

    /*
     * Set up Webshims
     */
    //webshims.setOptions('basePath', '/js-webshim/minified/shims/');
    webshims.polyfill("es5 geolocation canvas forms forms-ext mediaelement track filereader details");


    /*
    IE10 styling
    */
    var ieVersion = cs.getIEVersion();
    if (ieVersion.major == 10) {
      $("html").addClass("ie-10");
    }
    else if (ieVersion.major == 11) {
      $("html").addClass("ie-11");
    }

    /*
     * Do something when somethdng outside of x is clicked 
     */
    $(document).mousedown(function(e) {
        var clicked = $(e.target);
        if (clicked.is('#x') || clicked.parents().is('#x')) {
            //then don't do something.
            return;
        } else {
          //then do something
        }
    });
    
    /*
     * Vertical align on resize
     */
    $(window).resize(function(){
      cs.autoVertPadding('.v-center-on','.v-center-by');
    });

    $(window).load(function(){
      $(window).resize();
    });
  })( jQuery ); // End scripts
});



/*
NAMESPACE - notice that this is called outside of document ready. So although it is at the bottom, it's called first. 
*/
var cs = {
    /*
    FUNCTIONS
    */
    isSubstring: function(outer, inner) {
      return (function($) { //encapsulated
        outer = outer.toLowerCase();
        inner = inner.toLowerCase();

        if(outer.indexOf(inner) !== -1) return true;
        else return false;
      })( jQuery ); // End scripts
    },
    setMobileMenuVars: function(x) {
      return (function($) { //encapsulated
        var link, text;
        if(x.find("a").length > 0) {
          link = x.find("a").first().attr("href");
          text = x.find("a").first().text();
        }
        else {
          link = "none";
          text = x.text();
        }
        return new Array(link,text);
      })( jQuery ); // End scripts
    },
    getIEVersion: function() {
      return (function($) { //encapsulated
        var agent = navigator.userAgent;
        var reg = /MSIE\s?(\d+)(?:\.(\d+))?/i;
        var matches = agent.match(reg);
        if (matches !== null) {
            return { major: matches[1], minor: matches[2] };
        }
        return { major: "-1", minor: "-1" };
      })( jQuery ); // End scripts
    },
    autoVertPadding: function(x,container) {
      (function($) { //encapsulated
        $(container).each(function(){
          var outer_height = $(this).height();
          $(this).find(x).each(function(){
            var inner_height = $(this).height();
            var diff = outer_height - inner_height; 
            $(this).css("padding-top",diff/2+"px");  
          });
        });
      })( jQuery ); // End scripts
    }
};
