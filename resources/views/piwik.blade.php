<!-- Piwik -->
<script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
    _paq.push(["setDomains", ["*.labs.gpul.org", "*.labs.gpul.org"]]);
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
            {{ '(function() {' }}
    var u = "//analytics.gpul.org/";
    _paq.push(['setTrackerUrl', u + 'piwik.php']);
    _paq.push(['setSiteId', {{ env('PIWIK_SITE_ID', '4') }}]);
    var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
    g.type = 'text/javascript';
    g.async = true;
    g.defer = true;
    g.src = u + 'piwik.js';
    s.parentNode.insertBefore(g, s);
    {{ '})();' }}
</script>
<noscript><p><img src="//analytics.gpul.org/piwik.php?idsite=4" style="border:0;" alt=""/></p></noscript>
<!-- End Piwik Code -->
