;
var L=L||require('leaflet'),_MAX_POINT_INTERVAL_MS=15000,_SECOND_IN_MILLIS=1000,_MINUTE_IN_MILLIS=60*_SECOND_IN_MILLIS,_HOUR_IN_MILLIS=60*_MINUTE_IN_MILLIS,_DAY_IN_MILLIS=24*_HOUR_IN_MILLIS,_DEFAULT_MARKER_OPTS={startIconUrl:'pin-icon-start.png',endIconUrl:'pin-icon-end.png',shadowUrl:'pin-shadow.png',wptIconUrls:{'':'pin-icon-wpt.png',},iconSize:[33,50],shadowSize:[50,50],iconAnchor:[16,45],shadowAnchor:[16,47],clickable:!1};
var _DEFAULT_POLYLINE_OPTS={color:'blue'};
var _DEFAULT_GPX_OPTS={parseElements:['track','route','waypoint'],show_kilometer_point:!1,kilometer_point_options:{kilometer_point_color:'blue',kilometer_point_color_text:'white',kilometer_point_intervall:1,kilometer_point_radius:10,},show_mile_point:!0,mile_point_options:{mile_point_color:'blue',mile_point_color_text:'white',mile_intervall:1,mile_point_radius:10,},};
L.GPX=L.FeatureGroup.extend({initialize:function(t,e){e.max_point_interval=e.max_point_interval||_MAX_POINT_INTERVAL_MS;
e.marker_options=this._merge_objs(_DEFAULT_MARKER_OPTS,e.marker_options||{});
e.polyline_options=this._merge_objs(_DEFAULT_POLYLINE_OPTS,e.polyline_options||{});
e.gpx_options=this._merge_objs(_DEFAULT_GPX_OPTS,e.gpx_options||{});
L.Util.setOptions(this,e);
L.GPXTrackIcon=L.Icon.extend({options:e.marker_options});
this._gpx=t;
this._layers={};
this._init_info();
if(t){this._parse(t,e,this.options.async)}},get_duration_string:function(t,e){var i='';
if(t>=_DAY_IN_MILLIS){i+=Math.floor(t/_DAY_IN_MILLIS)+'d ';
t=t%_DAY_IN_MILLIS};
if(t>=_HOUR_IN_MILLIS){i+=Math.floor(t/_HOUR_IN_MILLIS)+':';
t=t%_HOUR_IN_MILLIS};
var o=Math.floor(t/_MINUTE_IN_MILLIS);
t=t%_MINUTE_IN_MILLIS;
if(o<10)i+='0';
i+=o+'\'';
var n=Math.floor(t/_SECOND_IN_MILLIS);
t=t%_SECOND_IN_MILLIS;
if(n<10)i+='0';
i+=n;
if(!e&&t>0)i+='.'+Math.round(Math.floor(t)*1000)/1000;
else i+='"';
return i},get_duration_string_iso:function(t,e){var i=this.get_duration_string(t,e);
return i.replace('\'',':').replace('"','')},to_miles:function(t){return t/1.60934},to_ft:function(t){return t*3.28084},m_to_km:function(t){return t/1000},m_to_mi:function(t){return t/1609.34},get_name:function(){return this._info.name},get_desc:function(){return this._info.desc},get_author:function(){return this._info.author},get_copyright:function(){return this._info.copyright},get_distance:function(){return this._info.length},get_distance_imp:function(){return this.to_miles(this.m_to_km(this.get_distance()))},get_start_time:function(){return this._info.duration.start},get_end_time:function(){return this._info.duration.end},get_moving_time:function(){return this._info.duration.moving},get_total_time:function(){return this._info.duration.total},get_moving_pace:function(){return this.get_moving_time()/this.m_to_km(this.get_distance())},get_moving_pace_imp:function(){return this.get_moving_time()/this.get_distance_imp()},get_moving_speed:function(){return this.m_to_km(this.get_distance())/(this.get_moving_time()/(3600*1000))},get_moving_speed_imp:function(){return this.to_miles(this.m_to_km(this.get_distance()))/(this.get_moving_time()/(3600*1000))},get_total_speed:function(){return this.m_to_km(this.get_distance())/(this.get_total_time()/(3600*1000))},get_total_speed_imp:function(){return this.to_miles(this.m_to_km(this.get_distance()))/(this.get_total_time()/(3600*1000))},get_elevation_gain:function(){return this._info.elevation.gain},get_elevation_loss:function(){return this._info.elevation.loss},get_elevation_gain_imp:function(){return this.to_ft(this.get_elevation_gain())},get_elevation_loss_imp:function(){return this.to_ft(this.get_elevation_loss())},get_elevation_data:function(){var t=this;
return this._info.elevation._points.map(function(e){return t._prepare_data_point(e,t.m_to_km,null,function(t,e){return t.toFixed(2)+' km, '+e.toFixed(0)+' m'})})},get_elevation_data_imp:function(){var t=this;
return this._info.elevation._points.map(function(e){return t._prepare_data_point(e,t.m_to_mi,t.to_ft,function(t,e){return t.toFixed(2)+' mi, '+e.toFixed(0)+' ft'})})},get_elevation_max:function(){return this._info.elevation.max},get_elevation_min:function(){return this._info.elevation.min},get_elevation_max_imp:function(){return this.to_ft(this.get_elevation_max())},get_elevation_min_imp:function(){return this.to_ft(this.get_elevation_min())},get_average_hr:function(){return this._info.hr.avg},get_average_temp:function(){return this._info.atemp.avg},get_average_cadence:function(){return this._info.cad.avg},get_heartrate_data:function(){var t=this;
return this._info.hr._points.map(function(e){return t._prepare_data_point(e,t.m_to_km,null,function(t,e){return t.toFixed(2)+' km, '+e.toFixed(0)+' bpm'})})},get_heartrate_data_imp:function(){var t=this;
return this._info.hr._points.map(function(e){return t._prepare_data_point(e,t.m_to_mi,null,function(t,e){return t.toFixed(2)+' mi, '+e.toFixed(0)+' bpm'})})},get_cadence_data:function(){var t=this;
return this._info.cad._points.map(function(e){return t._prepare_data_point(e,t.m_to_km,null,function(t,e){return t.toFixed(2)+' km, '+e.toFixed(0)+' rpm'})})},get_temp_data:function(){var t=this;
return this._info.atemp._points.map(function(e){return t._prepare_data_point(e,t.m_to_km,null,function(t,e){return t.toFixed(2)+' km, '+e.toFixed(0)+' degrees'})})},get_cadence_data_imp:function(){var t=this;
return this._info.cad._points.map(function(e){return t._prepare_data_point(e,t.m_to_mi,null,function(t,e){return t.toFixed(2)+' mi, '+e.toFixed(0)+' rpm'})})},get_temp_data_imp:function(){var t=this;
return this._info.atemp._points.map(function(e){return t._prepare_data_point(e,t.m_to_mi,null,function(t,e){return t.toFixed(2)+' mi, '+e.toFixed(0)+' degrees'})})},reload:function(){this._init_info();
this.clearLayers();
this._parse(this._gpx,this.options,this.options.async)},_merge_objs:function(t,e){var n={};
for(var i in t){n[i]=t[i]};
for(var i in e){n[i]=e[i]};
return n},_prepare_data_point:function(t,e,n,o){var i=[e&&e(t[0])||t[0],n&&n(t[1])||t[1]];
i.push(o&&o(i[0],i[1])||(i[0]+': '+i[1]));
return i},_init_info:function(){this._info={name:null,length:0.0,elevation:{gain:0.0,loss:0.0,max:0.0,min:Infinity,_points:[]},hr:{avg:0,_total:0,_points:[]},duration:{start:null,end:null,moving:0,total:0},atemp:{avg:0,_total:0,_points:[]},cad:{avg:0,_total:0,_points:[]}}},_load_xml:function(t,e,n,o){if(o==undefined)o=this.options.async;
if(n==undefined)n=this.options;
var i=new window.XMLHttpRequest();
i.open('GET',t,o);
try{i.overrideMimeType('text/xml')}catch(r){};
i.onreadystatechange=function(){if(i.readyState!=4)return;
if(i.status==200)e(i.responseXML,n)};
i.send(null)},_parse:function(t,e,i){var n=this,o=function(t,e){var i=n._parse_gpx_data(t,e);
if(!i)return;
n.addLayer(i);
n.fire('loaded')};
if(t.substr(0,1)==='<'){var r=new DOMParser();
if(i){setTimeout(function(){o(r.parseFromString(t,'text/xml'),e)})}
else{o(r.parseFromString(t,'text/xml'),e)}}
else{this._load_xml(t,o,e,i)}},_parse_gpx_data:function(t,e){var m,i,n,o=[],h=[],d=e.gpx_options.parseElements;
if(d.indexOf('route')>-1){h.push(['rte','rtept'])};
if(d.indexOf('track')>-1){h.push(['trkseg','trkpt'])};
var a=t.getElementsByTagName('name');
if(a.length>0){this._info.name=a[0].textContent};
var r=t.getElementsByTagName('desc');
if(r.length>0){this._info.desc=r[0].textContent};
var x=t.getElementsByTagName('author');
if(x.length>0){this._info.author=x[0].textContent};
var k=t.getElementsByTagName('copyright');
if(k.length>0){this._info.copyright=k[0].textContent};
for(m=0;m<h.length;m++){n=t.getElementsByTagName(h[m][0]);
for(i=0;i<n.length;i++){var u=this._parse_trkseg(n[i],t,e,h[m][1]);
if(u.length===0)continue;
var v=new L.Polyline(u,e.polyline_options);
this.fire('addline',{line:v});
o.push(v);
if(e.marker_options.startIcon||e.marker_options.startIconUrl){var f=new L.Marker(u[0],{clickable:e.marker_options.clickable,icon:e.marker_options.startIcon||new L.GPXTrackIcon({iconUrl:e.marker_options.startIconUrl})});
this.fire('addpoint',{point:f,point_type:'start'});
o.push(f)};
if(e.marker_options.endIcon||e.marker_options.endIconUrl){f=new L.Marker(u[u.length-1],{clickable:e.marker_options.clickable,icon:e.marker_options.endIcon||new L.GPXTrackIcon({iconUrl:e.marker_options.endIconUrl})});
this.fire('addpoint',{point:f,point_type:'end'});
o.push(f)}}};
this._info.hr.avg=Math.round(this._info.hr._total/this._info.hr._points.length);
this._info.cad.avg=Math.round(this._info.cad._total/this._info.cad._points.length);
this._info.atemp.avg=Math.round(this._info.atemp._total/this._info.atemp._points.length);
if(d.indexOf('waypoint')>-1){n=t.getElementsByTagName('wpt');
for(i=0;i<n.length;i++){var y=new L.LatLng(n[i].getAttribute('lat'),n[i].getAttribute('lon')),M=n[i].getElementsByTagName('name'),a='';
if(M.length>0){a=M[0].textContent};
var I=n[i].getElementsByTagName('desc'),r='';
if(I.length>0){r=I[0].textContent};
var N=n[i].getElementsByTagName('sym'),s='';
if(N.length>0){s=N[0].textContent};
var l=e.marker_options.wptIcons,p=e.marker_options.wptIconUrls,c;
if(l&&l[s]){c=l[s]}
else if(p&&p[s]){c=new L.GPXTrackIcon({iconUrl:p[s]})}
else if(l&&l['']){c=l['']}
else if(p&&p['']){c=new L.GPXTrackIcon({iconUrl:p['']})}
else{console.log('No icon or icon URL configured for symbol type "'+s+'", and no fallback configured; ignoring waypoint.');
continue};
var g=new L.Marker(y,{clickable:!0,title:a,icon:c});
g.bindPopup('<b>'+a+'</b>'+(r.length>0?'<br>'+r:'')).openPopup();
this.fire('addpoint',{point:g,point_type:'waypoint'});
o.push(g)}};
if(o.length>1){return new L.FeatureGroup(o)}
else if(o.length==1){return o[0]}},_parse_trkseg:function(t,i,n,d){var r=t.getElementsByTagName(d),h=[],m=[],k=this;
if(!r.length)return[];
var I=[],p=null;
for(var a=0;a<r.length;a++){var o,e=new L.LatLng(r[a].getAttribute('lat'),r[a].getAttribute('lon'));
e.meta={time:null,ele:null,hr:null,cad:null,atemp:null};
o=r[a].getElementsByTagName('time');
if(o.length>0){e.meta.time=new Date(Date.parse(o[0].textContent))}
else{e.meta.time=new Date('1970-01-01T00:00:00')};
o=r[a].getElementsByTagName('ele');
if(o.length>0){e.meta.ele=parseFloat(o[0].textContent)};
o=r[a].getElementsByTagNameNS('*','hr');
if(o.length>0){e.meta.hr=parseInt(o[0].textContent);
this._info.hr._points.push([this._info.length,e.meta.hr]);
this._info.hr._total+=e.meta.hr};
o=r[a].getElementsByTagNameNS('*','cad');
if(o.length>0){e.meta.cad=parseInt(o[0].textContent);
this._info.cad._points.push([this._info.length,e.meta.cad]);
this._info.cad._total+=e.meta.cad};
o=r[a].getElementsByTagNameNS('*','atemp');
if(o.length>0){e.meta.atemp=parseInt(o[0].textContent);
this._info.atemp._points.push([this._info.length,e.meta.atemp]);
this._info.atemp._total+=e.meta.atemp};
if(e.meta.ele>this._info.elevation.max){this._info.elevation.max=e.meta.ele};
if(e.meta.ele<this._info.elevation.min){this._info.elevation.min=e.meta.ele};
this._info.elevation._points.push([this._info.length,e.meta.ele]);
this._info.duration.end=e.meta.time;
if(p!=null){this._info.length+=this._dist3d(p,e);
if(n.gpx_options.show_kilometer_point||n.gpx_options.show_mile_point){if(this._parse_current_kilometer!=null){if(n.gpx_options.show_kilometer_point){if((parseInt(this._info.length/1000)-this._parse_current_kilometer)>n.gpx_options.kilometer_point_options.kilometer_point_intervall-1){this._parse_current_kilometer=parseInt(this._info.length/1000);
var u=new L.circleMarker(e,{radius:n.gpx_options.kilometer_point_options.kilometer_point_radius,stroke:!1,fillColor:n.gpx_options.kilometer_point_options.kilometer_point_color,fillOpacity:1,}).bindTooltip(this._parse_current_kilometer.toString(),{direction:'center',permanent:!0,interactive:!0,className:'kilometer_tooltip'});
h.push(u)}};
if(n.gpx_options.show_mile_point){if((parseInt(this.to_miles(this._info.length)/1000)-this._parse_current_mile)>n.gpx_options.mile_point_options.mile_intervall){this._parse_current_mile=parseInt(this.to_miles(this._info.length)/1000);
var u=new L.circleMarker(e,{radius:n.gpx_options.mile_point_options.mile_point_radius,stroke:!1,fillColor:n.gpx_options.mile_point_options.mile_point_color,fillOpacity:1,}).bindTooltip(this._parse_current_mile.toString(),{direction:'center',permanent:!0,interactive:!0,className:'mile_tooltip'});
m.push(u)}}}
else{this._parse_current_kilometer=parseInt(this._info.length/1000);
this._parse_current_mile=parseInt(this._info.length/1000);
var v=document.createElement('style');
document.head.appendChild(v);
var f=v.sheet,s='';
s+='.kilometer_tooltip, .mile_tooltip {';
s+='background: none!important;';
s+='border: none!important;';
s+='font-weight: 900!important;';
s+='font-size: larger!important;';
s+='box-shadow: none!important;';
s+='}';
f.insertRule(s,0);
var c='.kilometer_tooltip {';
c+='color: '+n.gpx_options.kilometer_point_options.kilometer_point_color_text+';';
c+='}';
f.insertRule(c,0);
var g='.mile_tooltip {';
g+='color: '+n.gpx_options.mile_point_options.mile_point_color_text+';';
g+='}';
f.insertRule(g,0)}};
var l=e.meta.ele-p.meta.ele;
if(l>0){this._info.elevation.gain+=l}
else{this._info.elevation.loss+=Math.abs(l)};
l=Math.abs(e.meta.time-p.meta.time);
this._info.duration.total+=l;
if(l<n.max_point_interval){this._info.duration.moving+=l}}
else if(this._info.duration.start==null){this._info.duration.start=e.meta.time};
p=e;
I.push(e)};
if(h.length>1){k.addLayer(new L.FeatureGroup(h))};
if(m.length>1){k.addLayer(new L.FeatureGroup(m))};
return I},_dist2d:function(t,e){var r=6371000,i=this._deg2rad(e.lat-t.lat),n=this._deg2rad(e.lng-t.lng),o=Math.sin(i/2)*Math.sin(i/2)+Math.cos(this._deg2rad(t.lat))*Math.cos(this._deg2rad(e.lat))*Math.sin(n/2)*Math.sin(n/2),a=2*Math.atan2(Math.sqrt(o),Math.sqrt(1-o)),s=r*a;
return s},_dist3d:function(t,e){var i=this._dist2d(t,e),n=Math.abs(e.meta.ele-t.meta.ele);
return Math.sqrt(Math.pow(i,2)+Math.pow(n,2))},_deg2rad:function(t){return t*Math.PI/180}});
if(typeof module==='object'&&typeof module.exports==='object'){module.exports=L}
else if(typeof define==='function'&&define.amd){define(L)};