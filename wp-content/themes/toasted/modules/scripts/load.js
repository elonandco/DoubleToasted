//////////// Mobile Friendly Homepage Images - Important to run first!
jQuery(document).ready(function() {
    var t = jQuery(".do-resize");
    if (t.length > 0) {
        var r = jQuery(window).width();
        t.each(480 > r ? function() {
            jQuery(this).attr("src", jQuery(this).attr("small"))
        } : 900 > r ? function() {
            jQuery(this).attr("src", jQuery(this).attr("medium"))
        } : function() {
            jQuery(this).attr("src", jQuery(this).attr("large"))
        })
    }
});

//////////// Owl Carousel - modules/scripts/carousel
eval(function(p, a, c, k, e, r) {
    e = function(c) {
        return (c < a ? '' : e(parseInt(c / a))) + ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c.toString(36))
    };
    if (!''.replace(/^/, String)) {
        while (c--) r[e(c)] = k[c] || e(c);
        k = [function(e) {
            return r[e]
        }];
        e = function() {
            return '\\w+'
        };
        c = 1
    };
    while (c--)
        if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
    return p
}('7(A 3c.3q!=="9"){3c.3q=9(e){9 t(){}t.5S=e;p 5R t}}(9(e,t,n){h r={1N:9(t,n){h r=c;r.$k=e(n);r.6=e.4M({},e.37.2B.6,r.$k.v(),t);r.2A=t;r.4L()},4L:9(){9 r(e){h n,r="";7(A t.6.33==="9"){t.6.33.R(c,[e])}l{1A(n 38 e.d){7(e.d.5M(n)){r+=e.d[n].1K}}t.$k.2y(r)}t.3t()}h t=c,n;7(A t.6.2H==="9"){t.6.2H.R(c,[t.$k])}7(A t.6.2O==="2Y"){n=t.6.2O;e.5K(n,r)}l{t.3t()}},3t:9(){h e=c;e.$k.v("d-4I",e.$k.2x("2w")).v("d-4F",e.$k.2x("H"));e.$k.z({2u:0});e.2t=e.6.q;e.4E();e.5v=0;e.1X=14;e.23()},23:9(){h e=c;7(e.$k.25().N===0){p b}e.1M();e.4C();e.$S=e.$k.25();e.E=e.$S.N;e.4B();e.$G=e.$k.17(".d-1K");e.$K=e.$k.17(".d-1p");e.3u="U";e.13=0;e.26=[0];e.m=0;e.4A();e.4z()},4z:9(){h e=c;e.2V();e.2W();e.4t();e.30();e.4r();e.4q();e.2p();e.4o();7(e.6.2o!==b){e.4n(e.6.2o)}7(e.6.O===j){e.6.O=4Q}e.19();e.$k.17(".d-1p").z("4i","4h");7(!e.$k.2m(":3n")){e.3o()}l{e.$k.z("2u",1)}e.5O=b;e.2l();7(A e.6.3s==="9"){e.6.3s.R(c,[e.$k])}},2l:9(){h e=c;7(e.6.1Z===j){e.1Z()}7(e.6.1B===j){e.1B()}e.4g();7(A e.6.3w==="9"){e.6.3w.R(c,[e.$k])}},3x:9(){h e=c;7(A e.6.3B==="9"){e.6.3B.R(c,[e.$k])}e.3o();e.2V();e.2W();e.4f();e.30();e.2l();7(A e.6.3D==="9"){e.6.3D.R(c,[e.$k])}},3F:9(){h e=c;t.1c(9(){e.3x()},0)},3o:9(){h e=c;7(e.$k.2m(":3n")===b){e.$k.z({2u:0});t.18(e.1C);t.18(e.1X)}l{p b}e.1X=t.4d(9(){7(e.$k.2m(":3n")){e.3F();e.$k.4b({2u:1},2M);t.18(e.1X)}},5x)},4B:9(){h e=c;e.$S.5n(\'<L H="d-1p">\').4a(\'<L H="d-1K"></L>\');e.$k.17(".d-1p").4a(\'<L H="d-1p-49">\');e.1H=e.$k.17(".d-1p-49");e.$k.z("4i","4h")},1M:9(){h e=c,t=e.$k.1I(e.6.1M),n=e.$k.1I(e.6.2i);7(!t){e.$k.I(e.6.1M)}7(!n){e.$k.I(e.6.2i)}},2V:9(){h t=c,n,r;7(t.6.2Z===b){p b}7(t.6.48===j){t.6.q=t.2t=1;t.6.1h=b;t.6.1s=b;t.6.1O=b;t.6.22=b;t.6.1Q=b;t.6.1R=b;p b}n=e(t.6.47).1f();7(n>(t.6.1s[0]||t.2t)){t.6.q=t.2t}7(t.6.1h!==b){t.6.1h.5g(9(e,t){p e[0]-t[0]});1A(r=0;r<t.6.1h.N;r+=1){7(t.6.1h[r][0]<=n){t.6.q=t.6.1h[r][1]}}}l{7(n<=t.6.1s[0]&&t.6.1s!==b){t.6.q=t.6.1s[1]}7(n<=t.6.1O[0]&&t.6.1O!==b){t.6.q=t.6.1O[1]}7(n<=t.6.22[0]&&t.6.22!==b){t.6.q=t.6.22[1]}7(n<=t.6.1Q[0]&&t.6.1Q!==b){t.6.q=t.6.1Q[1]}7(n<=t.6.1R[0]&&t.6.1R!==b){t.6.q=t.6.1R[1]}}7(t.6.q>t.E&&t.6.46===j){t.6.q=t.E}},4r:9(){h n=c,r,i;7(n.6.2Z!==j){p b}i=e(t).1f();n.3d=9(){7(e(t).1f()!==i){7(n.6.O!==b){t.18(n.1C)}t.5d(r);r=t.1c(9(){i=e(t).1f();n.3x()},n.6.45)}};e(t).44(n.3d)},4f:9(){h e=c;e.2g(e.m);7(e.6.O!==b){e.3j()}},43:9(){h t=c,n=0,r=t.E-t.6.q;t.$G.2f(9(i){h s=e(c);s.z({1f:t.M}).v("d-1K",3p(i));7(i%t.6.q===0||i===r){7(!(i>r)){n+=1}}s.v("d-24",n)})},42:9(){h e=c,t=e.$G.N*e.M;e.$K.z({1f:t*2,T:0});e.43()},2W:9(){h e=c;e.40();e.42();e.3Z();e.3v()},40:9(){h e=c;e.M=1F.4O(e.$k.1f()/e.6.q)},3v:9(){h e=c,t=(e.E*e.M-e.6.q*e.M)*-1;7(e.6.q>e.E){e.D=0;t=0;e.3z=0}l{e.D=e.E-e.6.q;e.3z=t}p t},3Y:9(){p 0},3Z:9(){h t=c,n=0,r=0,i,s,o;t.J=[0];t.3E=[];1A(i=0;i<t.E;i+=1){r+=t.M;t.J.2D(-r);7(t.6.12===j){s=e(t.$G[i]);o=s.v("d-24");7(o!==n){t.3E[n]=t.J[i];n=o}}}},4t:9(){h t=c;7(t.6.2a===j||t.6.1v===j){t.B=e(\'<L H="d-5A"/>\').5m("5l",!t.F.15).5c(t.$k)}7(t.6.1v===j){t.3T()}7(t.6.2a===j){t.3S()}},3S:9(){h t=c,n=e(\'<L H="d-4U"/>\');t.B.1o(n);t.1u=e("<L/>",{"H":"d-1n",2y:t.6.2U[0]||""});t.1q=e("<L/>",{"H":"d-U",2y:t.6.2U[1]||""});n.1o(t.1u).1o(t.1q);n.w("2X.B 21.B",\'L[H^="d"]\',9(e){e.1l()});n.w("2n.B 28.B",\'L[H^="d"]\',9(n){n.1l();7(e(c).1I("d-U")){t.U()}l{t.1n()}})},3T:9(){h t=c;t.1k=e(\'<L H="d-1v"/>\');t.B.1o(t.1k);t.1k.w("2n.B 28.B",".d-1j",9(n){n.1l();7(3p(e(c).v("d-1j"))!==t.m){t.1g(3p(e(c).v("d-1j")),j)}})},3P:9(){h t=c,n,r,i,s,o,u;7(t.6.1v===b){p b}t.1k.2y("");n=0;r=t.E-t.E%t.6.q;1A(s=0;s<t.E;s+=1){7(s%t.6.q===0){n+=1;7(r===s){i=t.E-t.6.q}o=e("<L/>",{"H":"d-1j"});u=e("<3N></3N>",{4R:t.6.39===j?n:"","H":t.6.39===j?"d-59":""});o.1o(u);o.v("d-1j",r===s?i:s);o.v("d-24",n);t.1k.1o(o)}}t.35()},35:9(){h t=c;7(t.6.1v===b){p b}t.1k.17(".d-1j").2f(9(){7(e(c).v("d-24")===e(t.$G[t.m]).v("d-24")){t.1k.17(".d-1j").Z("2d");e(c).I("2d")}})},3e:9(){h e=c;7(e.6.2a===b){p b}7(e.6.2e===b){7(e.m===0&&e.D===0){e.1u.I("1b");e.1q.I("1b")}l 7(e.m===0&&e.D!==0){e.1u.I("1b");e.1q.Z("1b")}l 7(e.m===e.D){e.1u.Z("1b");e.1q.I("1b")}l 7(e.m!==0&&e.m!==e.D){e.1u.Z("1b");e.1q.Z("1b")}}},30:9(){h e=c;e.3P();e.3e();7(e.B){7(e.6.q>=e.E){e.B.3K()}l{e.B.3J()}}},55:9(){h e=c;7(e.B){e.B.3k()}},U:9(e){h t=c;7(t.1E){p b}t.m+=t.6.12===j?t.6.q:1;7(t.m>t.D+(t.6.12===j?t.6.q-1:0)){7(t.6.2e===j){t.m=0;e="2k"}l{t.m=t.D;p b}}t.1g(t.m,e)},1n:9(e){h t=c;7(t.1E){p b}7(t.6.12===j&&t.m>0&&t.m<t.6.q){t.m=0}l{t.m-=t.6.12===j?t.6.q:1}7(t.m<0){7(t.6.2e===j){t.m=t.D;e="2k"}l{t.m=0;p b}}t.1g(t.m,e)},1g:9(e,n,r){h i=c,s;7(i.1E){p b}7(A i.6.1Y==="9"){i.6.1Y.R(c,[i.$k])}7(e>=i.D){e=i.D}l 7(e<=0){e=0}i.m=i.d.m=e;7(i.6.2o!==b&&r!=="4e"&&i.6.q===1&&i.F.1x===j){i.1t(0);7(i.F.1x===j){i.1L(i.J[e])}l{i.1r(i.J[e],1)}i.2r();i.4l();p b}s=i.J[e];7(i.F.1x===j){i.1T=b;7(n===j){i.1t("1w");t.1c(9(){i.1T=j},i.6.1w)}l 7(n==="2k"){i.1t(i.6.2v);t.1c(9(){i.1T=j},i.6.2v)}l{i.1t("1m");t.1c(9(){i.1T=j},i.6.1m)}i.1L(s)}l{7(n===j){i.1r(s,i.6.1w)}l 7(n==="2k"){i.1r(s,i.6.2v)}l{i.1r(s,i.6.1m)}}i.2r()},2g:9(e){h t=c;7(A t.6.1Y==="9"){t.6.1Y.R(c,[t.$k])}7(e>=t.D||e===-1){e=t.D}l 7(e<=0){e=0}t.1t(0);7(t.F.1x===j){t.1L(t.J[e])}l{t.1r(t.J[e],1)}t.m=t.d.m=e;t.2r()},2r:9(){h e=c;e.26.2D(e.m);e.13=e.d.13=e.26[e.26.N-2];e.26.5f(0);7(e.13!==e.m){e.35();e.3e();e.2l();7(e.6.O!==b){e.3j()}}7(A e.6.3y==="9"&&e.13!==e.m){e.6.3y.R(c,[e.$k])}},X:9(){h e=c;e.3A="X";t.18(e.1C)},3j:9(){h e=c;7(e.3A!=="X"){e.19()}},19:9(){h e=c;e.3A="19";7(e.6.O===b){p b}t.18(e.1C);e.1C=t.4d(9(){e.U(j)},e.6.O)},1t:9(e){h t=c;7(e==="1m"){t.$K.z(t.2z(t.6.1m))}l 7(e==="1w"){t.$K.z(t.2z(t.6.1w))}l 7(A e!=="2Y"){t.$K.z(t.2z(e))}},2z:9(e){p{"-1G-1a":"2C "+e+"1z 2s","-1W-1a":"2C "+e+"1z 2s","-o-1a":"2C "+e+"1z 2s",1a:"2C "+e+"1z 2s"}},3H:9(){p{"-1G-1a":"","-1W-1a":"","-o-1a":"",1a:""}},3I:9(e){p{"-1G-P":"1i("+e+"V, C, C)","-1W-P":"1i("+e+"V, C, C)","-o-P":"1i("+e+"V, C, C)","-1z-P":"1i("+e+"V, C, C)",P:"1i("+e+"V, C,C)"}},1L:9(e){h t=c;t.$K.z(t.3I(e))},3L:9(e){h t=c;t.$K.z({T:e})},1r:9(e,t){h n=c;n.29=b;n.$K.X(j,j).4b({T:e},{54:t||n.6.1m,3M:9(){n.29=j}})},4E:9(){h e=c,r="1i(C, C, C)",i=n.56("L"),s,o,u,a;i.2w.3O="  -1W-P:"+r+"; -1z-P:"+r+"; -o-P:"+r+"; -1G-P:"+r+"; P:"+r;s=/1i\\(C, C, C\\)/g;o=i.2w.3O.5i(s);u=o!==14&&o.N===1;a="5z"38 t||t.5Q.4P;e.F={1x:u,15:a}},4q:9(){h e=c;7(e.6.27!==b||e.6.1U!==b){e.3Q();e.3R()}},4C:9(){h e=c,t=["s","e","x"];e.16={};7(e.6.27===j&&e.6.1U===j){t=["2X.d 21.d","2N.d 3U.d","2n.d 3V.d 28.d"]}l 7(e.6.27===b&&e.6.1U===j){t=["2X.d","2N.d","2n.d 3V.d"]}l 7(e.6.27===j&&e.6.1U===b){t=["21.d","3U.d","28.d"]}e.16.3W=t[0];e.16.2K=t[1];e.16.2J=t[2]},3R:9(){h t=c;t.$k.w("5y.d",9(e){e.1l()});t.$k.w("21.3X",9(t){p e(t.1d).2m("5C, 5E, 5F, 5N")})},3Q:9(){9 s(e){7(e.2b!==W){p{x:e.2b[0].2c,y:e.2b[0].41}}7(e.2b===W){7(e.2c!==W){p{x:e.2c,y:e.41}}7(e.2c===W){p{x:e.52,y:e.53}}}}9 o(t){7(t==="w"){e(n).w(r.16.2K,a);e(n).w(r.16.2J,f)}l 7(t==="Q"){e(n).Q(r.16.2K);e(n).Q(r.16.2J)}}9 u(n){h u=n.3h||n||t.3g,a;7(u.5a===3){p b}7(r.E<=r.6.q){p}7(r.29===b&&!r.6.3f){p b}7(r.1T===b&&!r.6.3f){p b}7(r.6.O!==b){t.18(r.1C)}7(r.F.15!==j&&!r.$K.1I("3b")){r.$K.I("3b")}r.11=0;r.Y=0;e(c).z(r.3H());a=e(c).2h();i.2S=a.T;i.2R=s(u).x-a.T;i.2P=s(u).y-a.5o;o("w");i.2j=b;i.2L=u.1d||u.4c}9 a(o){h u=o.3h||o||t.3g,a,f;r.11=s(u).x-i.2R;r.2I=s(u).y-i.2P;r.Y=r.11-i.2S;7(A r.6.2E==="9"&&i.3C!==j&&r.Y!==0){i.3C=j;r.6.2E.R(r,[r.$k])}7((r.Y>8||r.Y<-8)&&r.F.15===j){7(u.1l!==W){u.1l()}l{u.5L=b}i.2j=j}7((r.2I>10||r.2I<-10)&&i.2j===b){e(n).Q("2N.d")}a=9(){p r.Y/5};f=9(){p r.3z+r.Y/5};r.11=1F.3v(1F.3Y(r.11,a()),f());7(r.F.1x===j){r.1L(r.11)}l{r.3L(r.11)}}9 f(n){h s=n.3h||n||t.3g,u,a,f;s.1d=s.1d||s.4c;i.3C=b;7(r.F.15!==j){r.$K.Z("3b")}7(r.Y<0){r.1y=r.d.1y="T"}l{r.1y=r.d.1y="3i"}7(r.Y!==0){u=r.4j();r.1g(u,b,"4e");7(i.2L===s.1d&&r.F.15!==j){e(s.1d).w("3a.4k",9(t){t.4S();t.4T();t.1l();e(t.1d).Q("3a.4k")});a=e.4N(s.1d,"4V").3a;f=a.4W();a.4X(0,0,f)}}o("Q")}h r=c,i={2R:0,2P:0,4Y:0,2S:0,2h:14,4Z:14,50:14,2j:14,51:14,2L:14};r.29=j;r.$k.w(r.16.3W,".d-1p",u)},4j:9(){h e=c,t=e.4m();7(t>e.D){e.m=e.D;t=e.D}l 7(e.11>=0){t=0;e.m=0}p t},4m:9(){h t=c,n=t.6.12===j?t.3E:t.J,r=t.11,i=14;e.2f(n,9(s,o){7(r-t.M/20>n[s+1]&&r-t.M/20<o&&t.34()==="T"){i=o;7(t.6.12===j){t.m=e.4p(i,t.J)}l{t.m=s}}l 7(r+t.M/20<o&&r+t.M/20>(n[s+1]||n[s]-t.M)&&t.34()==="3i"){7(t.6.12===j){i=n[s+1]||n[n.N-1];t.m=e.4p(i,t.J)}l{i=n[s+1];t.m=s+1}}});p t.m},34:9(){h e=c,t;7(e.Y<0){t="3i";e.3u="U"}l{t="T";e.3u="1n"}p t},4A:9(){h e=c;e.$k.w("d.U",9(){e.U()});e.$k.w("d.1n",9(){e.1n()});e.$k.w("d.19",9(t,n){e.6.O=n;e.19();e.32="19"});e.$k.w("d.X",9(){e.X();e.32="X"});e.$k.w("d.1g",9(t,n){e.1g(n)});e.$k.w("d.2g",9(t,n){e.2g(n)})},2p:9(){h e=c;7(e.6.2p===j&&e.F.15!==j&&e.6.O!==b){e.$k.w("57",9(){e.X()});e.$k.w("58",9(){7(e.32!=="X"){e.19()}})}},1Z:9(){h t=c,n,r,i,s,o;7(t.6.1Z===b){p b}1A(n=0;n<t.E;n+=1){r=e(t.$G[n]);7(r.v("d-1e")==="1e"){4s}i=r.v("d-1K");s=r.17(".5b");7(A s.v("1J")!=="2Y"){r.v("d-1e","1e");4s}7(r.v("d-1e")===W){s.3K();r.I("4u").v("d-1e","5e")}7(t.6.4v===j){o=i>=t.m}l{o=j}7(o&&i<t.m+t.6.q&&s.N){t.4w(r,s)}}},4w:9(e,n){9 o(){e.v("d-1e","1e").Z("4u");n.5h("v-1J");7(r.6.4x==="4y"){n.5j(5k)}l{n.3J()}7(A r.6.2T==="9"){r.6.2T.R(c,[r.$k])}}9 u(){i+=1;7(r.2Q(n.3l(0))||s===j){o()}l 7(i<=2q){t.1c(u,2q)}l{o()}}h r=c,i=0,s;7(n.5p("5q")==="5r"){n.z("5s-5t","5u("+n.v("1J")+")");s=j}l{n[0].1J=n.v("1J")}u()},1B:9(){9 s(){h r=e(n.$G[n.m]).2G();n.1H.z("2G",r+"V");7(!n.1H.1I("1B")){t.1c(9(){n.1H.I("1B")},0)}}9 o(){i+=1;7(n.2Q(r.3l(0))){s()}l 7(i<=2q){t.1c(o,2q)}l{n.1H.z("2G","")}}h n=c,r=e(n.$G[n.m]).17("5w"),i;7(r.3l(0)!==W){i=0;o()}l{s()}},2Q:9(e){h t;7(!e.3M){p b}t=A e.4D;7(t!=="W"&&e.4D===0){p b}p j},4g:9(){h t=c,n;7(t.6.2F===j){t.$G.Z("2d")}t.1D=[];1A(n=t.m;n<t.m+t.6.q;n+=1){t.1D.2D(n);7(t.6.2F===j){e(t.$G[n]).I("2d")}}t.d.1D=t.1D},4n:9(e){h t=c;t.4G="d-"+e+"-5B";t.4H="d-"+e+"-38"},4l:9(){9 a(e){p{2h:"5D",T:e+"V"}}h e=c,t=e.4G,n=e.4H,r=e.$G.1S(e.m),i=e.$G.1S(e.13),s=1F.4J(e.J[e.m])+e.J[e.13],o=1F.4J(e.J[e.m])+e.M/2,u="5G 5H 5I 5J";e.1E=j;e.$K.I("d-1P").z({"-1G-P-1P":o+"V","-1W-4K-1P":o+"V","4K-1P":o+"V"});i.z(a(s,10)).I(t).w(u,9(){e.3m=j;i.Q(u);e.31(i,t)});r.I(n).w(u,9(){e.36=j;r.Q(u);e.31(r,n)})},31:9(e,t){h n=c;e.z({2h:"",T:""}).Z(t);7(n.3m&&n.36){n.$K.Z("d-1P");n.3m=b;n.36=b;n.1E=b}},4o:9(){h e=c;e.d={2A:e.2A,5P:e.$k,S:e.$S,G:e.$G,m:e.m,13:e.13,1D:e.1D,15:e.F.15,F:e.F,1y:e.1y}},3G:9(){h r=c;r.$k.Q(".d d 21.3X");e(n).Q(".d d");e(t).Q("44",r.3d)},1V:9(){h e=c;7(e.$k.25().N!==0){e.$K.3r();e.$S.3r().3r();7(e.B){e.B.3k()}}e.3G();e.$k.2x("2w",e.$k.v("d-4I")||"").2x("H",e.$k.v("d-4F"))},5T:9(){h e=c;e.X();t.18(e.1X);e.1V();e.$k.5U()},5V:9(t){h n=c,r=e.4M({},n.2A,t);n.1V();n.1N(r,n.$k)},5W:9(e,t){h n=c,r;7(!e){p b}7(n.$k.25().N===0){n.$k.1o(e);n.23();p b}n.1V();7(t===W||t===-1){r=-1}l{r=t}7(r>=n.$S.N||r===-1){n.$S.1S(-1).5X(e)}l{n.$S.1S(r).5Y(e)}n.23()},5Z:9(e){h t=c,n;7(t.$k.25().N===0){p b}7(e===W||e===-1){n=-1}l{n=e}t.1V();t.$S.1S(n).3k();t.23()}};e.37.2B=9(t){p c.2f(9(){7(e(c).v("d-1N")===j){p b}e(c).v("d-1N",j);h n=3c.3q(r);n.1N(t,c);e.v(c,"2B",n)})};e.37.2B.6={q:5,1h:b,1s:[60,4],1O:[61,3],22:[62,2],1Q:b,1R:[63,1],48:b,46:b,1m:2M,1w:64,2v:65,O:b,2p:b,2a:b,2U:["1n","U"],2e:j,12:b,1v:j,39:b,2Z:j,45:2M,47:t,1M:"d-66",2i:"d-2i",1Z:b,4v:j,4x:"4y",1B:b,2O:b,33:b,3f:j,27:j,1U:j,2F:b,2o:b,3B:b,3D:b,2H:b,3s:b,1Y:b,3y:b,3w:b,2E:b,2T:b}})(67,68,69)', 62, 382, '||||||options|if||function||false|this|owl||||var||true|elem|else|currentItem|||return|items|||||data|on|||css|typeof|owlControls|0px|maximumItem|itemsAmount|browser|owlItems|class|addClass|positionsInArray|owlWrapper|div|itemWidth|length|autoPlay|transform|off|apply|userItems|left|next|px|undefined|stop|newRelativeX|removeClass||newPosX|scrollPerPage|prevItem|null|isTouch|ev_types|find|clearInterval|play|transition|disabled|setTimeout|target|loaded|width|goTo|itemsCustom|translate3d|page|paginationWrapper|preventDefault|slideSpeed|prev|append|wrapper|buttonNext|css2slide|itemsDesktop|swapSpeed|buttonPrev|pagination|paginationSpeed|support3d|dragDirection|ms|for|autoHeight|autoPlayInterval|visibleItems|isTransition|Math|webkit|wrapperOuter|hasClass|src|item|transition3d|baseClass|init|itemsDesktopSmall|origin|itemsTabletSmall|itemsMobile|eq|isCss3Finish|touchDrag|unWrap|moz|checkVisible|beforeMove|lazyLoad||mousedown|itemsTablet|setVars|roundPages|children|prevArr|mouseDrag|mouseup|isCssFinish|navigation|touches|pageX|active|rewindNav|each|jumpTo|position|theme|sliding|rewind|eachMoveUpdate|is|touchend|transitionStyle|stopOnHover|100|afterGo|ease|orignalItems|opacity|rewindSpeed|style|attr|html|addCssSpeed|userOptions|owlCarousel|all|push|startDragging|addClassActive|height|beforeInit|newPosY|end|move|targetElement|200|touchmove|jsonPath|offsetY|completeImg|offsetX|relativePos|afterLazyLoad|navigationText|updateItems|calculateAll|touchstart|string|responsive|updateControls|clearTransStyle|hoverStatus|jsonSuccess|moveDirection|checkPagination|endCurrent|fn|in|paginationNumbers|click|grabbing|Object|resizer|checkNavigation|dragBeforeAnimFinish|event|originalEvent|right|checkAp|remove|get|endPrev|visible|watchVisibility|Number|create|unwrap|afterInit|logIn|playDirection|max|afterAction|updateVars|afterMove|maximumPixels|apStatus|beforeUpdate|dragging|afterUpdate|pagesInArray|reload|clearEvents|removeTransition|doTranslate|show|hide|css2move|complete|span|cssText|updatePagination|gestures|disabledEvents|buildButtons|buildPagination|mousemove|touchcancel|start|disableTextSelect|min|loops|calculateWidth|pageY|appendWrapperSizes|appendItemsSizes|resize|responsiveRefreshRate|itemsScaleUp|responsiveBaseWidth|singleItem|outer|wrap|animate|srcElement|setInterval|drag|updatePosition|onVisibleItems|block|display|getNewPosition|disable|singleItemTransition|closestItem|transitionTypes|owlStatus|inArray|moveEvents|response|continue|buildControls|loading|lazyFollow|lazyPreload|lazyEffect|fade|onStartup|customEvents|wrapItems|eventTypes|naturalWidth|checkBrowser|originalClasses|outClass|inClass|originalStyles|abs|perspective|loadContent|extend|_data|round|msMaxTouchPoints|5e3|text|stopImmediatePropagation|stopPropagation|buttons|events|pop|splice|baseElWidth|minSwipe|maxSwipe|dargging|clientX|clientY|duration|destroyControls|createElement|mouseover|mouseout|numbers|which|lazyOwl|appendTo|clearTimeout|checked|shift|sort|removeAttr|match|fadeIn|400|clickable|toggleClass|wrapAll|top|prop|tagName|DIV|background|image|url|wrapperWidth|img|500|dragstart|ontouchstart|controls|out|input|relative|textarea|select|webkitAnimationEnd|oAnimationEnd|MSAnimationEnd|animationend|getJSON|returnValue|hasOwnProperty|option|onstartup|baseElement|navigator|new|prototype|destroy|removeData|reinit|addItem|after|before|removeItem|1199|979|768|479|800|1e3|carousel|jQuery|window|document'.split('|'), 0, {}))

//////////// Salvattore Masonry Grid - modules/scripts/salvattore.js
! function(e, t) {
    "object" == typeof exports ? module.exports = t() : "function" == typeof define && define.amd ? define("salvattore", [], t) : e.salvattore = t()
}(this, function() {
    window.matchMedia || (window.matchMedia = function() {
            var e = window.styleMedia || window.media;
            if (!e) {
                var t = document.createElement("style"),
                    n = document.getElementsByTagName("script")[0],
                    r = null;
                t.type = "text/css", t.id = "matchmediajs-test", n.parentNode.insertBefore(t, n), r = "getComputedStyle" in window && window.getComputedStyle(t, null) || t.currentStyle, e = {
                    matchMedium: function(e) {
                        var n = "@media " + e + "{ #matchmediajs-test { width: 1px; } }";
                        return t.styleSheet ? t.styleSheet.cssText = n : t.textContent = n, "1px" === r.width
                    }
                }
            }
            return function(t) {
                return {
                    matches: e.matchMedium(t || "all"),
                    media: t || "all"
                }
            }
        }()),
        function() {
            if (window.matchMedia && window.matchMedia("all").addListener) return !1;
            var e = window.matchMedia,
                t = e("only all").matches,
                n = !1,
                r = 0,
                a = [],
                i = function() {
                    clearTimeout(r), r = setTimeout(function() {
                        for (var t = 0, n = a.length; n > t; t++) {
                            var r = a[t].mql,
                                i = a[t].listeners || [],
                                o = e(r.media).matches;
                            if (o !== r.matches) {
                                r.matches = o;
                                for (var c = 0, l = i.length; l > c; c++) i[c].call(window, r)
                            }
                        }
                    }, 30)
                };
            window.matchMedia = function(r) {
                var o = e(r),
                    c = [],
                    l = 0;
                return o.addListener = function(e) {
                    t && (n || (n = !0, window.addEventListener("resize", i, !0)), 0 === l && (l = a.push({
                        mql: o,
                        listeners: c
                    })), c.push(e))
                }, o.removeListener = function(e) {
                    for (var t = 0, n = c.length; n > t; t++) c[t] === e && c.splice(t, 1)
                }, o
            }
        }(),
        function() {
            for (var e = 0, t = ["ms", "moz", "webkit", "o"], n = 0; n < t.length && !window.requestAnimationFrame; ++n) window.requestAnimationFrame = window[t[n] + "RequestAnimationFrame"], window.cancelAnimationFrame = window[t[n] + "CancelAnimationFrame"] || window[t[n] + "CancelRequestAnimationFrame"];
            window.requestAnimationFrame || (window.requestAnimationFrame = function(t) {
                var n = (new Date).getTime(),
                    r = Math.max(0, 16 - (n - e)),
                    a = window.setTimeout(function() {
                        t(n + r)
                    }, r);
                return e = n + r, a
            }), window.cancelAnimationFrame || (window.cancelAnimationFrame = function(e) {
                clearTimeout(e)
            })
        }();
    var e = function(e, t) {
        var n = {},
            r = [],
            a = function(e, t, n) {
                e.dataset ? e.dataset[t] = n : e.setAttribute("data-" + t, n)
            };
        return n.obtain_grid_settings = function(t) {
            var n, r, a = e.getComputedStyle(t, ":before"),
                i = a.getPropertyValue("content").slice(1, -1),
                o = i.match(/^\s*(\d+)(?:\s?\.(.+))?\s*$/);
            return o ? (n = o[1], r = o[2], r = r ? r.split(".") : ["column"]) : (o = i.match(/^\s*\.(.+)\s+(\d+)\s*$/), r = o[1], n = o[2], n && (n = n.split("."))), {
                numberOfColumns: n,
                columnClasses: r
            }
        }, n.add_columns = function(e, r) {
            for (var i, o = n.obtain_grid_settings(e), c = o.numberOfColumns, l = o.columnClasses, s = new Array(+c), d = t.createDocumentFragment(), u = c; 0 !== u--;) i = "[data-columns] > *:nth-child(" + c + "n-" + u + ")", s.push(r.querySelectorAll(i));
            s.forEach(function(e) {
                var n = t.createElement("div"),
                    r = t.createDocumentFragment();
                n.className = l.join(" "), Array.prototype.forEach.call(e, function(e) {
                    r.appendChild(e)
                }), n.appendChild(r), d.appendChild(n)
            }), e.appendChild(d), a(e, "columns", c)
        }, n.remove_columns = function(n) {
            var r = t.createRange();
            r.selectNodeContents(n);
            var i = Array.prototype.filter.call(r.extractContents().childNodes, function(t) {
                    return t instanceof e.HTMLElement
                }),
                o = i.length,
                c = i[0].childNodes.length,
                l = new Array(c * o);
            Array.prototype.forEach.call(i, function(e, t) {
                Array.prototype.forEach.call(e.children, function(e, n) {
                    l[n * o + t] = e
                })
            });
            var s = t.createElement("div");
            return a(s, "columns", 0), l.filter(function(e) {
                return !!e
            }).forEach(function(e) {
                s.appendChild(e)
            }), s
        }, n.recreate_columns = function(t) {
            e.requestAnimationFrame(function() {
                n.add_columns(t, n.remove_columns(t))
            })
        }, n.media_query_change = function(e) {
            e.matches && Array.prototype.forEach.call(r, n.recreate_columns)
        }, n.get_css_rules = function(e) {
            var t;
            try {
                t = e.sheet.cssRules || e.sheet.rules
            } catch (n) {
                return []
            }
            return t || []
        }, n.get_stylesheets = function() {
            return Array.prototype.concat.call(Array.prototype.slice.call(t.querySelectorAll("style[type='text/css']")), Array.prototype.slice.call(t.querySelectorAll("link[rel='stylesheet']")))
        }, n.media_rule_has_columns_selector = function(e) {
            for (var t, n = e.length; n--;)
                if (t = e[n], t.selectorText && t.selectorText.match(/\[data-columns\](.*)::?before$/)) return !0;
            return !1
        }, n.scan_media_queries = function() {
            var t = [];
            e.matchMedia && (n.get_stylesheets().forEach(function(r) {
                Array.prototype.forEach.call(n.get_css_rules(r), function(r) {
                    r.media && n.media_rule_has_columns_selector(r.cssRules) && t.push(e.matchMedia(r.media.mediaText))
                })
            }), t.forEach(function(e) {
                e.addListener(n.media_query_change)
            }))
        }, n.next_element_column_index = function(e, t) {
            var n, r, a, i = e.children,
                o = i.length,
                c = 0,
                l = 0;
            for (a = 0; o > a; a++) n = i[a], fragchild = t[a].children ? t[a].children.length : 0, r = n.children.length + fragchild, 0 === c && (c = r), c > r && (l = a, c = r);
            return l
        }, n.create_list_of_fragments = function(e) {
            for (var n = new Array(e), r = 0; r !== e;) n[r] = t.createDocumentFragment(), r++;
            return n
        }, n.append_elements = function(e, t) {
            var r = e.children,
                a = r.length,
                i = n.create_list_of_fragments(a);
            t.forEach(function(t) {
                var r = n.next_element_column_index(e, i);
                i[r].appendChild(t)
            }), Array.prototype.forEach.call(r, function(e, t) {
                e.appendChild(i[t])
            })
        }, n.prepend_elements = function(e, r) {
            var a = e.children,
                i = a.length,
                o = n.create_list_of_fragments(i),
                c = i - 1;
            r.forEach(function(e) {
                var t = o[c];
                t.insertBefore(e, t.firstChild), 0 === c ? c = i - 1 : c--
            }), Array.prototype.forEach.call(a, function(e, t) {
                e.insertBefore(o[t], e.firstChild)
            });
            for (var l = t.createDocumentFragment(), s = r.length % i; 0 !== s--;) l.appendChild(e.lastChild);
            e.insertBefore(l, e.firstChild)
        }, n.register_grid = function(i) {
            if ("none" !== e.getComputedStyle(i).display) {
                var o = t.createRange();
                o.selectNodeContents(i);
                var c = t.createElement("div");
                c.appendChild(o.extractContents()), a(c, "columns", 0), n.add_columns(i, c), r.push(i)
            }
        }, n.init = function() {
            var e = t.createElement("style");
            e.innerHTML = "[data-columns]::before{visibility:hidden;position:absolute;font-size:1px;}", t.head.appendChild(e);
            var r = t.querySelectorAll("[data-columns]");
            Array.prototype.forEach.call(r, n.register_grid), n.scan_media_queries()
        }, n.init(), {
            append_elements: n.append_elements,
            prepend_elements: n.prepend_elements,
            register_grid: n.register_grid
        }
    }(window, window.document);
    return e
});

//////////// Viewport Checker for Animated Scrolling - modules/scripts/jquery.viewportchecker.js
! function(t) {
    t.fn.viewportChecker = function(e) {
        var o = {
            classToAdd: "visible",
            offset: 100,
            repeat: !1,
            callbackFunction: function() {},
            scrollHorizontal: !1
        };
        t.extend(o, e);
        var a = this,
            s = o.scrollHorizontal ? t(window).width() : t(window).height(),
            l = -1 != navigator.userAgent.toLowerCase().indexOf("webkit") ? "body" : "html";
        return this.checkElements = function() {
            if (o.scrollHorizontal) var e = t(l).scrollLeft(),
                r = e + s;
            else var e = t(l).scrollTop(),
                r = e + s;
            a.each(function() {
                var e = t(this),
                    a = {},
                    s = {};
                if (e.data("add") && (s.classToAdd = e.data("add")), e.data("offset") && (s.offset = e.data("offset")), e.data("repeat") && (s.repeat = e.data("repeat")), e.data("scrollHorizontal") && (s.scrollHorizontal = e.data("scrollHorizontal")), t.extend(a, o), t.extend(a, s), !e.hasClass(a.classToAdd) || a.repeat) {
                    {
                        var l = a.scrollHorizontal ? Math.round(e.offset().left) + a.offset : Math.round(e.offset().top) + a.offset;
                        l + e.height()
                    }
                    r > l ? (e.addClass(a.classToAdd), a.callbackFunction(e, "add")) : e.hasClass(a.classToAdd) && a.repeat && (e.removeClass(a.classToAdd), a.callbackFunction(e, "remove"))
                }
            })
        }, t(window).bind("load scroll touchmove", this.checkElements), t(window).resize(function(t) {
            s = o.scrollHorizontal ? t.currentTarget.innerWidth : t.currentTarget.innerHeight
        }), this.checkElements(), this
    }
}(jQuery);

//////////// Main Theme Functions - modules/scripts/load.js
function dtAnimateScrolling(e) {
    jQuery(e).viewportChecker({
        classToAdd: "visible",
        offset: 0,
        repeat: !1
    })
}

function initiateCall() {
    console.log("Initiating phone authentication"), jQuery.ajax({
        type: "POST",
        url: callpath + "call.php",
        data: {
            auth_phone_number: jQuery("#auth_phone_number").val()
        },
        success: function(e) {
            console.log(e), e.error ? "verified" == e.verification_code ? auth_success() : showError(e.error) : (showCodeForm(e.verification_code), checkStatus())
        },
        error: function(e, t, r) {
            console.log("Error initiating authentication"), showError(t)
        }
    })
}

function showError(e) {
    jQuery("#auth_verify_error").text(e), jQuery("#auth_enter_number,#auth_verify_code").slideUp(500), jQuery("#auth_verify_again,#auth_verify_error").delay(600).slideDown()
}

function showCodeForm(e) {
    jQuery("#auth_verification_code").text(e), jQuery("#auth_enter_number, #auth_verify_error").slideUp(500), jQuery("#auth_verify_code, #auth_verify_again").delay(600).slideDown(), window.dot_load_loop = loadingDots()
}

function checkStatus() {
    jQuery.ajax({
        type: "POST",
        url: callpath + "status.php",
        data: {
            auth_phone_number: jQuery("#auth_phone_number").val()
        },
        success: function(e) {
            console.log("Successfully checked status.php"), updateStatus(e.status)
        },
        error: function(e, t, r) {
            console.log("Error returned from status.php")
        }
    })
}

function updateStatus(e) {
    "unverified" == e ? setTimeout(checkStatus, 3e3) : auth_success()
}

function loadingDots() {
    var e = 0;
    window.setInterval(function() {
        e++;
        var t = new Array(e % 10).join(".");
        jQuery("#auth_verify_code #status").html("Waiting." + t)
    }, 1e3)
}

function auth_success() {
    window.clearInterval(window.dot_load_loop), jQuery("#auth_verify_code, #auth_verify_again, #auth_enter_number, #auth_header_sub").slideUp(500), jQuery("#auth_header").text("Your account has been verified. Thanks!")
}
if (jQuery("#menu-main-menu .menu-item-has-children").on({
        touchstart: function() {
            return jQuery("#menu-main-menu .menu-item-has-children").children(".sub-menu").css("max-height", "0px"), jQuery(this).children(".sub-menu").css("max-height", "400px"), jQuery(this).hasClass("current-touch") ? void 0 : (jQuery(this).addClass("current-touch"), !1)
        }
    }), jQuery(document).ready(function() {
        var e = jQuery.cookie("dt-visited"),
            t = jQuery(".home-page");
        null == e && t.length > 0 && (jQuery(".dt-open-feature, .dt-featured").addClass("active"), jQuery.cookie("dt-visited", "yes", {
            expires: 1,
            path: "/"
        }))
    }), jQuery(window).load(function() {
        window.location.href.indexOf("login=failed") > -1 && (jQuery("#dt-toggle-login").click(), jQuery("#dt-lightbox-login #error-fail").addClass("active"), homeOwl.trigger("owl.stop"))
    }), jQuery("#dt-toggle-login").click(function() {
        homeOwl.trigger("owl.stop")
    }), jQuery(window).load(function() {
        var e = jQuery(".dt-featured"),
            t = jQuery(".dt-featured").hasClass("active"),
            r = !1;
        t && (r = !0), jQuery(".dt-open-feature").click(function() {
            r ? (e.animate({
                height: "0px"
            }, 200), r = !1, jQuery(this).toggleClass("active"), e.toggleClass("active")) : (autoHeight = e.css("height", "auto").height(), e.height("0px").animate({
                height: autoHeight
            }, 200), r = !0, jQuery(this).toggleClass("active"))
        });
        var a = jQuery("#dt-mobile-nav-menu"),
            i = !1;
        jQuery("#dt-open-mob-menu").click(function() {
            if(!i){
                jQuery('body').css({overflow:'hidden'});
            }else {
                jQuery('body').css({overflow:'visible'});
            }

            i ? (a.animate({
                height: "0px"
            }, 200), i = !1, jQuery(this).toggleClass("active"), a.toggleClass("active")) : (autoHeight = a.css("height", "auto").height(), a.height("0px").animate({
                height: autoHeight
            }, 200), i = !0, jQuery(this).toggleClass("active"))
        })
    }), jQuery(".dt-schedule")) {
    var d = new Date,
        dtdayno = d.getDay(),
        dtdayclass = ".dt-schedule .day-" + dtdayno;
    jQuery(dtdayclass).addClass("active")
}
jQuery("#dt-media-subscribe") && (jQuery("#dt-audio-click").click(function() {
    jQuery("#dt-video-option").slideUp(200), jQuery("#dt-audio-choice").fadeIn(300)
}), jQuery("#dt-video-click").click(function() {
    jQuery("#dt-video-option").slideUp(200), jQuery("#dt-video-choice").fadeIn(300)
})), jQuery("#dt-side-comments .activity-read-more a").on("click", function(e) {
    var t = jQuery(e.target),
        r = t.parent().attr("id").split("-"),
        a = r[3],
        i = t.parent().parent();
    return jQuery.post(ajaxurl, {
        action: "get_single_activity_content",
        activity_id: a
    }, function(e) {
        jQuery(i).slideUp().html(e).slideDown()
    }), !1
}), jQuery(".dt-usr-wall-post").on("click", function(e) {
    var t = jQuery(this).attr("user"),
        r = jQuery("#whats-new");
    jQuery("#whats-new-form-home").addClass("active"), jQuery(this).slideUp(200), jQuery("#home-post-update").slideDown(400), jQuery(".rtmedia-container").fadeIn(), jQuery("#whats-new").focus(), r.val(""), r.val("@" + t + " - ")
}), jQuery(".dt-usr-home-compose").on("click", function(e) {
    jQuery("#whats-new-form-home").addClass("active"), jQuery(this).slideUp(200), jQuery("#home-post-update").slideDown(400), jQuery(".rtmedia-container").fadeIn(), jQuery("#whats-new").select()
}), jQuery(".friendship-button.is_friend a").hover(function() {
    jQuery(this).text("REMOVE")
}, function() {
    jQuery(this).text("FRIENDS")
});
var singlePageLike = jQuery("#dt-likeit");
singlePageLike.click(function() {
    singlePageLike.stop();
    var e = singlePageLike.hasClass("faved") ? "unfav" : "fav",
        t = singlePageLike.attr("activity"),
        r = singlePageLike.attr("postid");
    return "fav" == e ? singlePageLike.addClass("faved") : singlePageLike.removeClass("faved"), jQuery.post(ajaxurl, {
        action: "activity_mark_" + e,
        id: t,
        single: r
    }, function(t) {
        console.log(t), "fav" == e ? singlePageLike.addClass("faved") : singlePageLike.removeClass("faved")
    }), !1
}), jQuery(".dt-group-switch").live("click", function(e) {
    var t = jQuery(this).hasClass("list-view"),
        r = jQuery(".dt-new-group-list-switch").hasClass("active");
    return t !== r ? (jQuery(".dt-new-group-list-switch").toggleClass("active"), jQuery(".group-dir-entry").hide().removeClass("visible"), dtAnimateScrolling(".animate-post"), jQuery(".group-dir-entry").show(), jQuery("html, body").scroll(), jQuery(".dt-group-switch").removeClass("active"), jQuery(this).toggleClass("active"), !1) : (e.preventDefault(), void e.stopPropagation())
}), jQuery(document).ready(function() {
    dtAnimateScrolling(".animate-post")
}), jQuery("body").on("bpActivityLoaded", function() {
    dtAnimateScrolling('.animate-post');
    jQuery('html, body').scroll();
    jQuery('.review-archive .dt-archive-thumb-small').hover(function() {
        jQuery(this).children('.dt-archive-review-meta').fadeIn();
    }, function() {
        jQuery(this).children('.dt-archive-review-meta').fadeOut();
    });
    jQuery('.new-audio-format .dt-archive-thumb-small').unbind();
    jQuery('.new-audio-format .dt-archive-thumb-small').click(function(e) {
        return jQuery(this).parent().hasClass('active') ||
            (jQuery('.new-audio-format .post').removeClass('active'),
                jQuery('.new-audio-format .post .dt-archive-audio-player').slideUp(100),
                jQuery(this).parent().toggleClass('active'),
                jQuery(this).children('.dt-archive-audio-player').slideDown(100)), !1
    });
    jQuery('.pds-rate-wrap').each(function() {
        var el = jQuery(this).first('script').text();
        var arg_string = el.substring(el.lastIndexOf('{'), el.lastIndexOf('}') + 1);

        if (arg_string) {
            arg_obj                                    = JSON.parse(arg_string);
            window["PDRTJS_7999183" + arg_obj.item_id] = new PDRTJS_RATING(arg_obj);
        }
    })
}), jQuery("body").on("gridloaded", function() {
    isgroups = jQuery("#groups-list"), salvisinit = isgroups.attr("data-columns"), isgroups.length && !salvisinit && (grid = document.querySelector("#groups-list"), salvattore.register_grid(grid)), dtAnimateScrolling(".animate-post"), jQuery("html, body").scroll()
}), jQuery("body").on("postFilterloaded", function() {
    reviews = jQuery(".review-archive"), audio_archive = jQuery(".new-audio-format"), !reviews.length > 0 && !audio_archive.length > 0 ? (grid = document.querySelector(".dt-make-grid"), salvattore.register_grid(grid)) : (jQuery(".review-archive .dt-archive-thumb-small").hover(function() {
        jQuery(this).children(".dt-archive-review-meta").fadeIn()
    }, function() {
        jQuery(this).children(".dt-archive-review-meta").fadeOut()
    }), jQuery(".new-audio-format .dt-archive-thumb-small").unbind(), jQuery(".new-audio-format .dt-archive-thumb-small").click(function(e) {
        return jQuery(this).parent().hasClass("active") ? void 0 : (jQuery(".new-audio-format .post").removeClass("active"), jQuery(".new-audio-format .post .dt-archive-audio-player").slideUp(100), jQuery(this).parent().toggleClass("active"), jQuery(this).children(".dt-archive-audio-player").slideDown(100), !1)
    })), jQuery(".pds-rate-wrap").each(function() {
        el = jQuery(this).first("script").text(), arg_string = el.substring(el.lastIndexOf("{"), el.lastIndexOf("}") + 1), arg_obj = JSON.parse(arg_string), window["PDRTJS_7999183" + arg_obj.item_id] = new PDRTJS_RATING(arg_obj)
    }), dtAnimateScrolling(".animate-post"), jQuery("html, body").scroll()
}), jQuery.magnificPopup.instance.close = function() {
    jQuery.magnificPopup.proto.close.call(this), jQuery("body").css("overflow", "initial"), jQuery("#dt-window-wrap").css("width", "100%")
}, jQuery("#load-more-dt-posts a").click(function() {
    var pageInfo = jQuery(this).parent();

    pageInfo.addClass('loading');

    var page        = parseInt(pageInfo.data('currentpage')) + 1;
    var lastpage    = parseInt(pageInfo.data('lastpage'));
    var type        = pageInfo.data('type');
    var cat         = pageInfo.data('category');
    var sort        = pageInfo.data('sort');
    var query       = pageInfo.attr('query');
    var nonce       = pageInfo.data('meta');
    var e = {
        action:     'get_more_dt_posts',
        query:      query,
        type:       type,
        sort:       sort,
        page:       page,
        category:   cat,
        nonce:      nonce
    };

    return jq.post(ajaxurl, e, function(e) {
        if (e.length < 120 && e.indexOf('Couldn\'t load more posts.') > -1) {
            jQuery('#load-more-dt-posts').hide();
            jQuery('.show-more-wrap').append(e);
            pageInfo.removeClass('loading');
        } else {
            if (cat !== 'reviews' && type !== 'dt-audio') {
                var t = document.querySelector('.show-more-wrap');
                jQuery(e).each(function(e, r) {
                    var a = document.createElement('div');
                    salvattore.append_elements(t, [a]);
                    jQuery(a).html(r)
                })
            } else {
                jQuery('.show-more-wrap').append(e);
            }

            jQuery('body').trigger('bpActivityLoaded');
            pageInfo.data('currentpage', page);
            page !== lastpage ? pageInfo.removeClass('loading') : (pageInfo.removeClass('loading'), pageInfo.fadeOut())
        }
    }), !1
}), jQuery('#dt-posts-order-by li').click(function() {
    var pageInfo = jQuery(this);
    // pageInfo.parent().addClass('active');
    jQuery('.show-more-wrap').animate({
        opacity: 0
    }, 1500);

    window.series_filter && (window.series_filter.abort(), series_sort = jQuery('#dt-posts-series-order-by'), series_sort.parent().removeClass('active'), pageInfo.parent().data('category', series_sort.data('order')), jQuery('#load-more-dt-posts').data('category', series_sort.data('order')));

    window.search_filter && (window.search_filter.abort(), jQuery('#dt-posts-custom-search').removeClass('active'), jQuery('#load-more-dt-posts').attr('query', jQuery('#dt-posts-custom-search #s').val()));

    var query   = jQuery('#dt-posts-custom-search #s').val();
    var sort    = pageInfo.data('orderby');
    var order   = pageInfo.data('order') || 'asc';
    var type    = pageInfo.parent().data('type');
    var cat     = pageInfo.parent().data('category');
    var nonce   = pageInfo.parent().data('meta');

    /*console.log('query: ' + query);
    console.log('sort: ' + sort);
    console.log('order: ' + order);
    console.log('type: ' + type);
    console.log('cat: ' + cat);
    console.log('nonce: ' + nonce);*/

    var e = {
        action: 'get_more_dt_posts',
        query:      query,
        sort:       sort,
        order:      order,
        type:       type,
        page:       1,
        category:   cat,
        nonce:      nonce
    };

    return window.order_filter = jq.post(ajaxurl, e, function(e) {
        jQuery('.show-more-wrap').animate({
            opacity: 1
        }, 250);

        jQuery('#dt-posts-order-by').removeClass('active');
        jQuery('.show-more-wrap').html(e);
        jQuery('#load-more-dt-posts').show();
        jQuery('body').trigger('postFilterloaded');

        var loadmore = jQuery('#load-more-dt-posts');
        loadmore.fadeIn();
        loadmore.data('sort', sort);
        loadmore.data('currentpage', 1);
        delete window.order_filter
    }), !1
}), jQuery('#dt-posts-series-order-by li').click(function() {
    jQuery(this).children('option[value="false"]').text('All Shows');
    // jQuery(this).addClass('active');
    jQuery('.show-more-wrap').animate({
        opacity: "0"
    }, 1500);
    window.order_filter && (window.order_filter.abort(), jQuery('#dt-posts-order-by').removeClass('active'), jQuery('#load-more-dt-posts').attr('sort', jQuery('#dt-posts-order-by').val()));
    window.search_filter && (window.search_filter.abort(), jQuery('#dt-posts-custom-search').removeClass('active'), jQuery('#load-more-dt-posts').attr('query', jQuery('#dt-posts-custom-search #s').val()));

    var pageInfo = jQuery('#dt-posts-order-by');
    var query    = jQuery('#dt-posts-custom-search #s').val();
    var sort     = pageInfo.data('orderby') || 'newest';
    var order    = pageInfo.data('order') || 'desc';
    var type     = pageInfo.data('type');
    var cat      = jQuery(this).data('orderby');
    var nonce    = pageInfo.data('meta');

    var t = {
        action: 'get_more_dt_posts',
        query:      query,
        sort:       sort,
        order:      order,
        type:       type,
        page:       1,
        category:   cat,
        nonce:      nonce
    };

    //type = "dt-audio";
    return window.series_filter = jQuery.ajax({
        url: ajaxurl,
        data: t,
        type: "POST",
        success: function(data) {
            jQuery('.show-more-wrap').animate({
                opacity: '1'
            }, 250);
            jQuery('#load-more-dt-posts').show();
            jQuery('#dt-posts-order-by').data('category', cat);
            jQuery('#load-more-dt-posts').data('category', cat);
            jQuery('#dt-posts-series-order-by').removeClass('active');
            jQuery('.show-more-wrap').html(data);
            jQuery('body').trigger('postFilterloaded');
            loadmore = jQuery('#load-more-dt-posts');
            loadmore.fadeIn();
            loadmore.data('sort', sort);
            loadmore.data('currentpage', 1);
            delete window.series_filter
        }
    }), !1
}), jQuery('#dt-posts-custom-search').submit(function(e) {
    e.preventDefault();
    jQuery(this).addClass('active');
    jQuery('.show-more-wrap').animate({
        opacity: '0'
    }, 1500);
    window.order_filter && (window.order_filter.abort(), jQuery('#dt-posts-order-by').removeClass('active'), jQuery('#dt-posts-order-by').attr('category', jQuery('#dt-posts-series-order-by').val()));
    window.series_filter && (window.series_filter.abort(), jQuery('#dt-posts-series-order-by').removeClass('active'));

    var pageInfo = jQuery('#dt-posts-order-by');
    var query    = jQuery(this).children('#s').val();
    var sort     = pageInfo.data('orderby') || 'newest';
    var order    = pageInfo.data('order') || 'desc';
    var type     = pageInfo.data('type');
    var cat      = pageInfo.data('category');
    var nonce    = pageInfo.data('meta');


    var t = {
        action: 'get_more_dt_posts',
        query:      query,
        sort:       sort,
        order:      order,
        type:       type,
        page:       1,
        category:   cat,
        nonce:      nonce
    };

    console.log(ajaxurl);

    return window.search_filter = jQuery.ajax({
        url: ajaxurl,
        data: t,
        type: "POST",
        success: function(data) {
            jQuery('.show-more-wrap').animate({
                opacity: '1'
            }, 250);
            jQuery('#dt-posts-custom-search').removeClass('active');
            jQuery('#dt-posts-series-order-by').removeClass('active');
            if(data === "none") {
                (jQuery(".show-more-wrap").html('<div class="large-12 columns" style="padding-top:50px;"><h3>We couldn\'t find anything that matched those keywords.</h3></div>'), jQuery("#load-more-dt-posts").hide(), delete window.search_filter)
            } else {
                (
                    jQuery('.show-more-wrap').html(data), jQuery('#load-more-dt-posts').show(),
                    jQuery('body').trigger('postFilterloaded'),

                    loadmore = jQuery('#load-more-dt-posts'),
                    loadmore.fadeIn(),
                    loadmore.data('sort', sort),
                    loadmore.data('currentpage', 1),
                    delete window.search_filter
                )
            }
        }
    }), !1
}), jQuery(".review-archive .dt-archive-thumb-small").hover(function() {
    jQuery(this).children(".dt-archive-review-meta").fadeIn()
}, function() {
    jQuery(this).children(".dt-archive-review-meta").fadeOut()
}), jQuery("#mobile-menu .menu-item-has-children > a").click(function(e) {
    jQuery(this).parent().children("ul").hasClass("active") || (jQuery(this).parent().children("ul").toggleClass("active"), jQuery("#dt-mobile-nav-menu").css("height", "auto"), e.preventDefault())
}), jQuery(".new-audio-format .dt-archive-thumb-small").click(function(e) {
    return jQuery(this).parent().hasClass("active") || (jQuery(".new-audio-format .post .dt-archive-audio-player").slideUp(100), jQuery(".new-audio-format .post").removeClass("active"), jQuery(this).parent().toggleClass("active"), jQuery(this).children(".dt-archive-audio-player").slideDown(100)), !1
});
var is_poll = jQuery(".PDS_Poll");
if (is_poll.length > 0) {
    view_results_link = jQuery(".pds-view-results"), view_results_link.hide(), jQuery("body").append(view_results_link);
    var refresh_functions = [];
    jQuery(".pds-view-results").each(function() {
        href = jQuery(this).attr("href"), arg_string = href.substring(href.lastIndexOf(":") + 1, href.lastIndexOf(")") + 1), refresh_functions.push(arg_string)
    }), new_results_link = '<div style="display:block;"><a href="" id="refresh_all_results">Show/Refresh Poll Results</a></div>', jQuery(".PDS_Poll").first().before(new_results_link), jQuery("#refresh_all_results").click(function() {
        return jQuery(refresh_functions).each(function(index) {
            eval(refresh_functions[index])
        }), !1
    })
}
jQuery(document).on("submit", "#custom-search", function() {
    var e = jQuery(this).children("#s").val();
    return jQuery.ajax({
        type: "post",
        url: ajaxurl,
        data: {
            action: "load_search_results",
            query: e
        },
        success: function(e) {
            console.log(e)
        }
    }), !1
}), jQuery(document).ready(function() {
    jQuery("#auth_submit").click(function(e) {
        e.stopPropagation(), e.preventDefault(), initiateCall()
    })
});
var callpath = "/wp-content/themes/toasted/modules/twilio/";
jQuery("#dt_try_call_again").click(function(e) {
        jQuery("#auth_verify_code, #auth_verify_again").slideUp(500), jQuery("#auth_enter_number").delay(600).slideDown()
    }),
    function(e, t) {
        var r;
        e.hj = e.hj || function() {
            (e.hj.q = e.hj.q || []).push(arguments)
        }, e._hjSettings = {
            hjid: 16944,
            hjsv: 3
        }, r = t.createElement("script"), r.async = 1, r.src = "//static.hotjar.com/c/hotjar-16944.js?sv=3", t.getElementsByTagName("head")[0].appendChild(r)
    }(window, document);