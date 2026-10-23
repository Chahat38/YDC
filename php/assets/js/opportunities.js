/* Add or edit opportunities here. type: Scholarship | Conference | Fellowship | Volunteering | Competition */
(function(){
var DATA=[
{t:'Chevening Scholarships',o:'UK Government',type:'Scholarship',w:'United Kingdom',when:'Applications usually open Aug to Nov',d:'Fully funded one-year master’s degree at a UK university for future leaders.',u:'https://www.chevening.org'},
{t:'Fulbright Program for Pakistan',o:'USEFP',type:'Scholarship',w:'United States',when:'Check the current call on the official site',d:'Funded master’s and PhD study in the US for Pakistani graduates.',u:'https://www.usefp.org'},
{t:'Türkiye Burslari',o:'Government of Türkiye',type:'Scholarship',w:'Türkiye',when:'Applications usually open Jan to Feb',d:'Fully funded undergraduate, master’s and PhD scholarships with a language year.',u:'https://turkiyeburslari.gov.tr'},
{t:'Chinese Government Scholarship',o:'China Scholarship Council',type:'Scholarship',w:'China',when:'Usually opens in the first half of the year',d:'Funded degree programs at Chinese universities, applied for through the CSC portal.',u:'https://www.campuschina.org'},
{t:'DAAD Scholarships',o:'German Academic Exchange Service',type:'Scholarship',w:'Germany',when:'Varies by program',d:'Study and research scholarships for master’s and doctoral students.',u:'https://www.daad.de'},
{t:'Erasmus Mundus Joint Masters',o:'European Union',type:'Scholarship',w:'Europe',when:'Usually opens Oct to Feb',d:'Joint master’s degrees taught in two or more European countries, with funding.',u:'https://erasmus-plus.ec.europa.eu'},
{t:'HEC Scholarships',o:'Higher Education Commission',type:'Scholarship',w:'Pakistan and abroad',when:'Announced throughout the year',d:'National and overseas scholarship programs for Pakistani students.',u:'https://www.hec.gov.pk'},
{t:'Google Summer of Code',o:'Google',type:'Fellowship',w:'Online',when:'Contributor applications usually open Mar to Apr',d:'Paid open-source mentorship for beginner contributors, working remotely on real projects.',u:'https://summerofcode.withgoogle.com'},
{t:'Hackathons for students',o:'Major League Hacking',type:'Competition',w:'Online and international',when:'Events run all year',d:'A season-long list of student hackathons, many of them online and beginner friendly.',u:'https://mlh.io'},
{t:'Online hackathons',o:'Devpost',type:'Competition',w:'Online',when:'New events listed every week',d:'Find global hackathons with prizes, from AI to climate to social impact.',u:'https://devpost.com'},
{t:'Web Summit',o:'Web Summit',type:'Conference',w:'Lisbon, Portugal',when:'Held every November',d:'One of the largest technology and startup conferences, with student ticket options.',u:'https://websummit.com'},
{t:'Google I/O',o:'Google',type:'Conference',w:'Online and California',when:'Held every May',d:'Google’s developer conference, with keynotes and sessions free to watch online.',u:'https://io.google'},
{t:'AIESEC global volunteer',o:'AIESEC',type:'Volunteering',w:'International',when:'Rolling applications',d:'Short volunteer and professional exchanges abroad run by a youth-led network.',u:'https://aiesec.org'},
{t:'UN Volunteers',o:'United Nations',type:'Volunteering',w:'Online and international',when:'Rolling applications',d:'Online and on-site volunteer assignments with UN agencies for young people.',u:'https://www.unv.org'}
];
var box=document.getElementById('opp-grid'),fb=document.querySelector('.opp-filters');if(!box)return;
var types=['All'].concat(DATA.map(function(x){return x.type}).filter(function(v,i,a){return a.indexOf(v)===i}));
function esc(s){return String(s).replace(/[&<>"]/g,function(c){return{'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]})}
function draw(f){box.innerHTML=DATA.filter(function(x){return f==='All'||x.type===f}).map(function(x){
return '<article class="opp" data-type="'+esc(x.type)+'"><span class="opp-tag">'+esc(x.type)+'</span><h3>'+esc(x.t)+'</h3><p class="opp-org">'+esc(x.o)+' · '+esc(x.w)+'</p><p>'+esc(x.d)+'</p><p class="opp-when">'+esc(x.when)+'</p><a class="btn btn-o" href="'+esc(x.u)+'" target="_blank" rel="noopener">Official site</a></article>'}).join('')}
fb.innerHTML=types.map(function(t,i){return '<button type="button" aria-pressed="'+(i===0)+'">'+t+'</button>'}).join('');
fb.addEventListener('click',function(e){var b=e.target.closest('button');if(!b)return;[].forEach.call(fb.children,function(x){x.setAttribute('aria-pressed',x===b)});draw(b.textContent)});
draw('All');})();
