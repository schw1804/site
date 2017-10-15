<?php
$dave_is_testing = (substr($_SERVER['HTTP_USER_AGENT'],-4) == ' DJS');

function custom_head()
{
    echo <<< ONREADY
    <script type='text/javascript'>
    $(function()
    {
        $($('a')[0]).hover(function()
        {
            var ti = $($('img')[0]),
                src = ti.attr('src');
            ti.attr('src',src.replace('ee2','ee1'));
        },                 function()
        {
            var ti = $($('img')[0]),
                src = ti.attr('src');
            ti.attr('src',src.replace('ee1','ee2'));
        });
        $(window).resize(function()
        {
            var tg=$('img:eq(0)');
            tg.width(Math.min($('img:eq(1)').position().left-4,150));
        });
        $('#btnD').click(function(e){
            var site = $('input[name=sitesearch]:checked').val(),
                iq   = $('input[name=q]'),
                q    = iq.val(),
                nq   = q + (site > '' ? ' ' + 'site:voluntaryist.com' : '');
            location.href='https://www.duckduckgo.com?q=' + nq;
            return false;
        });
        $('#num').click(function(){
            if(isNaN($(this).val()))
            {
                $(this).val('');
            }
        });
        $('#num').blur(function(){
            if(isNaN($(this).val()))
            {
                $(this).val($(this).attr('inx'));
            }
        });
        $('#nbtn').click(function(){
            issNum = isNaN($('#num').val())
                ? prompt("Which issue do you want?")
                : $('#num').val();
            if(issNum)
            {
                var vertPos = $(window).scrollTop();
                while( vertPos == $(window).scrollTop() && issNum > 1 )
                {
                    location.hash='#i'+(1000+issNum).substr(-3);
                    issNum = ''+(--issNum);
                }
            }
            return false;
        });
        $("inum").submit(function(){return false;});
        $('.aboer').click(function(){window.open('http://openexchangerates.org/'); return false;});
    });
    </script>
ONREADY;
}

add_filter("wp_enqueue_scripts", "custom_head", 10, 2);

function djs_sc_addthis()
{
    return <<< ATEND
    <!-- AddThis Button BEGIN -->
    <div class="addthis_default_style"
        style="position:absolute;right:10px;top:10px;z-index:5;line-height:1;">
    <!--a class="at300b" title="Creative Commons" href="/creative-commons/">
        <img style="height:16px;" src="/imgs/cc.png" alt="Creative Commons"></a -->
    <a class="at300b" title="Contribute on GitHub" href="https://github.com/voluntaryist/site">
      <img style="height:16px;" src="/imgs/GitHub-Mark-32px.png" alt="Contribute on GitHub"></a>
    <a class="addthis_button_preferred_1"></a>
    <a class="addthis_button_preferred_2"></a>
    <a class="addthis_button_preferred_3"></a>
    <a class="addthis_button_preferred_4"></a>
    <a class="addthis_button_compact"></a>
    <a class="addthis_counter addthis_bubble_style"></a>
    </div>
    <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50dcd8de709483c2"></script>
    <!-- AddThis Button END -->
ATEND;
}

function djs_sc_quote()
{
    require_once("/home/voluntar/public_html/quotelist.php");
    srand((date('mYd')+1)*count($quotes));
    $qi = rand(0,count($quotes));
    if(date('mYd') == 9201704)
    {
        $qi = 0;
    }
    return "<!-- ".date('mYd')." -->".$quotes[$qi];
}

function djs_disqus()
{
    $disq = <<< DISQ
        <div id="disqus_thread" style="width: 500px"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'voluntaryist'; // required: replace example with your forum shortname

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
DISQ;

    return $disq;
}

function djs_priceAt( $atts )
{
    require_once("/home/voluntar/public_html/funcs.php");
    $a = shortcode_atts( array(
        'name' => 'Payment',
        'doll' => 1,
        ), $atts);
    return priceAt2($a['doll'],$a['name'],true);
}

function djs_quotes()
{
    require_once('/home/voluntar/public_html/quotelist.php');
    $qs = "";
    foreach($quotes as $q)
    {
        $qs .= "$q<hr/>";
    }
    return $qs;
}

add_shortcode('all-quotes','djs_quotes');
add_shortcode('daily-quote','djs_sc_quote');
add_shortcode('addthis','djs_sc_addthis');
add_shortcode('disqus-by-dave','djs_disqus');
add_shortcode('djs-price-at','djs_priceAt'); // [djs-price-at doll="X" name="y"]

function djs_header($h)
{
    static $hn = 0;
    $hn = $hn+1;
    if(is_array($h))
    {
        $h = print_r($h,true);
    }
    if(!headers_sent())
    {
        header("DJS$hn: $h");
    }
    else
    {
        echo("Tried to write header $h");
    }
}

function custom_order_category( $query ) {

    // exit out if it's the admin or it isn't the main query
    if ( is_admin() || ! $query->is_main_query() )
    {
        return;
    }
    // order category archives by title in ascending order
    if ( is_category(3) ) // 3 is "How I Became"
    {
        $query->set( 'order' , 'asc' );
        $query->set( 'orderby', 'title');
        return;
    }
    elseif ( is_category(28) ) // 28 is "Articles"
    {
        $query->set( 'order' , 'asc' );
        $query->set( 'orderby', 'ID');
        // The theme php page will insert the Issue #s.
        // --------------------------------------------
        return;
    }
}
add_action( 'pre_get_posts', 'custom_order_category', 1 );

if($dave_is_testing)
{
    function daveLog($x)
    {
        file_put_contents('/home/voluntar/public_html/DaveLog.txt', date('d M Y H:i:s').': '.$x."\r\n", FILE_APPEND);
    }
}
else
{
    function daveLog($x) {}
}
