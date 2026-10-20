(function(){
  var $=function(s,r){return (r||document).querySelector(s)}, $$=function(s,r){return [].slice.call((r||document).querySelectorAll(s))};

  /* ---------- navigation ---------- */
  var nav=$('nav.main'), burger=$('.burger'), scrim=$('.scrim');
  function setNav(o){nav.classList.toggle('open',o);scrim.classList.toggle('on',o);burger.setAttribute('aria-expanded',o);document.body.style.overflow=o?'hidden':''}
  if(burger){burger.addEventListener('click',function(){setNav(true)});scrim.addEventListener('click',function(){setNav(false)});$('.nav-close').addEventListener('click',function(){setNav(false)})}
  $$('nav.main li.has-drop > button').forEach(function(b){
    b.addEventListener('click',function(e){
      var li=b.parentNode, was=li.classList.contains('open');
      $$('nav.main li.open').forEach(function(x){x.classList.remove('open');$('button',x).setAttribute('aria-expanded','false')});
      if(!was){li.classList.add('open');b.setAttribute('aria-expanded','true')}
      e.stopPropagation();
    });
  });
  document.addEventListener('click',function(){$$('nav.main li.open').forEach(function(x){x.classList.remove('open')})});
  document.addEventListener('keydown',function(e){if(e.key==='Escape'){setNav(false);$$('nav.main li.open').forEach(function(x){x.classList.remove('open')});closeLb()}});

  /* ---------- lightbox (gallery lives inside pages) ---------- */
  var lb=$('.lb'), imgs=$$('.gal button'), cur=0;
  function showLb(i){cur=(i+imgs.length)%imgs.length;var im=$('img',imgs[cur]);$('img',lb).src=im.getAttribute('data-full')||im.src;$('img',lb).alt=im.alt;lb.classList.add('on')}
  function closeLb(){if(lb)lb.classList.remove('on')}
  if(lb){
    imgs.forEach(function(b,i){b.addEventListener('click',function(){showLb(i)})});
    $('.x',lb).addEventListener('click',closeLb);$('.pv',lb).addEventListener('click',function(){showLb(cur-1)});$('.nx',lb).addEventListener('click',function(){showLb(cur+1)});
    lb.addEventListener('click',function(e){if(e.target===lb)closeLb()});
  }

  /* ---------- forms ---------- */
  var cfg=window.YDC_CONFIG||{};
  function rule(f){
    var v=(f.value||'').trim(), n=f.name, msg='';
    if(f.required&&!v) msg='This field is required.';
    else if(n==='email'&&v&&!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) msg='Enter a valid email, like name@example.com';
    else if(n==='phone'&&v&&!/^[+0-9\s-]{10,16}$/.test(v)) msg='Enter a valid mobile number, like 0300 1234567';
    var box=f.closest('.fld'); if(box){box.classList.toggle('bad',!!msg);var e=$('.err',box);if(e)e.textContent=msg}
    return !msg;
  }
  $$('form.f').forEach(function(form){
    var fields=$$('input,select,textarea',form).filter(function(x){return x.name&&x.type!=='hidden'&&!x.classList.contains('hp-in')});
    fields.forEach(function(f){f.addEventListener('blur',function(){rule(f)});f.addEventListener('input',function(){if(f.closest('.fld.bad'))rule(f)})});

    // prefill ?for=
    var sel=$('select[name="program"]',form), q=new URLSearchParams(location.search).get('for');
    if(sel&&q){for(var i=0;i<sel.options.length;i++){if(sel.options[i].value===q||sel.options[i].getAttribute('data-key')===q){sel.selectedIndex=i;break}}}

    form.addEventListener('submit',function(e){
      e.preventDefault();
      if($('.hp-in',form)&&$('.hp-in',form).value) return;           // bot trap
      var okAll=true; fields.forEach(function(f){if(!rule(f))okAll=false});
      if(!okAll){var b=$('.fld.bad input,.fld.bad select,.fld.bad textarea',form);if(b)b.focus();return}
      var data={}; fields.forEach(function(f){data[f.name]=f.value.trim()});
      data.form=form.getAttribute('data-form')||'registration';
      data.submitted_at=new Date().toISOString(); data.page=location.pathname.split('/').pop();
      var ref='YDC-'+Date.now().toString(36).toUpperCase().slice(-6); data.reference=ref;
      var btn=$('button[type=submit]',form), old=btn.innerHTML; btn.disabled=true; btn.textContent='Sending…';
      var alertBox=$('.alert',form.parentNode); if(alertBox)alertBox.classList.remove('show');

      function done(){
        form.style.display='none'; var ok=$('.ok',form.parentNode); $('.ref',ok).textContent=ref;
        $('.who',ok).textContent=data.name.split(' ')[0]; ok.classList.add('show'); ok.scrollIntoView({behavior:'smooth',block:'center'});
      }
      function fail(){
        btn.disabled=false; btn.innerHTML=old;
        if(alertBox){alertBox.textContent='We could not send the form. Check your internet connection and try again, or email ydc@kust.edu.pk.';alertBox.classList.add('show')}
      }
      if(cfg.formEndpoint){
        var gas=/script\.google\.com/.test(cfg.formEndpoint);
        var opts=gas?{method:'POST',mode:'no-cors',headers:{'Content-Type':'text/plain;charset=utf-8'},body:JSON.stringify(data)}
                    :{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json'},body:JSON.stringify(data)};
        fetch(cfg.formEndpoint,opts).then(function(r){if(gas||r.ok)done();else fail()}).catch(fail);
      } else {
        // fallback: opens the email app with a ready-made message
        var lines=Object.keys(data).filter(function(k){return ['form','submitted_at','page'].indexOf(k)<0}).map(function(k){return k+': '+data[k]});
        var subj=encodeURIComponent('['+data.form+'] '+(data.program||data.subject||'Submission')+' — '+data.name);
        location.href='mailto:'+(cfg.notifyEmail||'ydc@kust.edu.pk')+'?subject='+subj+'&body='+encodeURIComponent(lines.join('\n'));
        setTimeout(done,600);
      }
    });
  });
})();

/* glass navbar: firmer on scroll */
(function(){var h=document.querySelector("header.site");if(!h)return;var f=function(){h.classList.toggle("scrolled",window.scrollY>32)};f();window.addEventListener("scroll",f,{passive:true});window.addEventListener("pageshow",f)})();
