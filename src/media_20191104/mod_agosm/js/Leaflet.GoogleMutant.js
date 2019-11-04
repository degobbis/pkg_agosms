L.GridLayer.GoogleMutant=L.GridLayer.extend({options:{minZoom:0,maxZoom:23,tileSize:256,subdomains:'abc',errorTileUrl:'',attribution:'',opacity:1,continuousWorld:!1,noWrap:!1,type:'roadmap',maxNativeZoom:21},initialize:function(t){L.GridLayer.prototype.initialize.call(this,t);this._ready=!!window.google&&!!window.google.maps&&!!window.google.maps.Map;this._GAPIPromise=this._ready?Promise.resolve(window.google):new Promise(function(t,e){var n=0,i=null;i=setInterval(function(){if(n>=10){clearInterval(i);return e(new Error('window.google not found after 10 attempts'))};if(!!window.google&&!!window.google.maps&&!!window.google.maps.Map){clearInterval(i);return t(window.google)};n++},500)});this._tileCallbacks={};this._freshTiles={};this._imagesPerTile=(this.options.type==='hybrid')?2:1;this._boundOnMutatedImage=this._onMutatedImage.bind(this)},onAdd:function(t){L.GridLayer.prototype.onAdd.call(this,t);this._initMutantContainer();this._GAPIPromise.then(function(){this._ready=!0;this._map=t;this._initMutant();t.on('viewreset',this._reset,this);if(this.options.updateWhenIdle){t.on('moveend',this._update,this)}
else{t.on('move',this._update,this)};t.on('zoomend',this._handleZoomAnim,this);t.on('resize',this._resize,this);google.maps.event.addListenerOnce(this._mutant,'idle',function(){this._checkZoomLevels();this._mutantIsReady=!0}.bind(this));t._controlCorners.bottomright.style.marginBottom='20px';t._controlCorners.bottomleft.style.marginBottom='20px';this._reset();this._update();if(this._subLayers){for(var e in this._subLayers){this._subLayers[e].setMap(this._mutant)}}}.bind(this))},onRemove:function(t){L.GridLayer.prototype.onRemove.call(this,t);t._container.removeChild(this._mutantContainer);this._mutantContainer=undefined;google.maps.event.clearListeners(t,'idle');google.maps.event.clearListeners(this._mutant,'idle');t.off('viewreset',this._reset,this);t.off('move',this._update,this);t.off('moveend',this._update,this);t.off('zoomend',this._handleZoomAnim,this);t.off('resize',this._resize,this);if(t._controlCorners){t._controlCorners.bottomright.style.marginBottom='0em';t._controlCorners.bottomleft.style.marginBottom='0em'}},getAttribution:function(){return this.options.attribution},setElementSize:function(t,e){t.style.width=e.x+'px';t.style.height=e.y+'px'},addGoogleLayer:function(t,e){if(!this._subLayers)this._subLayers={};return this._GAPIPromise.then(function(){var n=google.maps[t],i=new n(e);i.setMap(this._mutant);this._subLayers[t]=i;return i}.bind(this))},removeGoogleLayer:function(t){var e=this._subLayers&&this._subLayers[t];if(!e)return;e.setMap(null);delete this._subLayers[t]},_initMutantContainer:function(){if(!this._mutantContainer){this._mutantContainer=L.DomUtil.create('div','leaflet-google-mutant leaflet-top leaflet-left');this._mutantContainer.id='_MutantContainer_'+L.Util.stamp(this._mutantContainer);this._mutantContainer.style.zIndex='800';this._mutantContainer.style.pointerEvents='none';L.DomEvent.off(this._mutantContainer);this._map.getContainer().appendChild(this._mutantContainer)};this.setOpacity(this.options.opacity);this.setElementSize(this._mutantContainer,this._map.getSize());this._attachObserver(this._mutantContainer)},_initMutant:function(){if(!this._ready||!this._mutantContainer)return;this._mutantCenter=new google.maps.LatLng(0,0);var t=new google.maps.Map(this._mutantContainer,{center:this._mutantCenter,zoom:0,tilt:0,mapTypeId:this.options.type,disableDefaultUI:!0,keyboardShortcuts:!1,draggable:!1,disableDoubleClickZoom:!0,scrollwheel:!1,streetViewControl:!1,styles:this.options.styles||{},backgroundColor:'transparent'});this._mutant=t;google.maps.event.addListenerOnce(t,'idle',function(){var e=this._mutantContainer.querySelectorAll('a');for(var t=0;t<e.length;t++){e[t].style.pointerEvents='auto'}}.bind(this));this.fire('spawned',{mapObject:t})},_attachObserver:function(t){var e=new MutationObserver(this._onMutations.bind(this));e.observe(t,{childList:!0,subtree:!0})},_onMutations:function(t){for(var n=0;n<t.length;++n){var s=t[n];for(var i=0;i<s.addedNodes.length;++i){var e=s.addedNodes[i];if(e instanceof HTMLImageElement){this._onMutatedImage(e)}
else if(e instanceof HTMLElement){Array.prototype.forEach.call(e.querySelectorAll('img'),this._boundOnMutatedImage);if(e.style.backgroundColor==='white'){L.DomUtil.remove(e)};if(e.textContent.indexOf('For development purposes only')===0){L.DomUtil.remove(e)};Array.prototype.forEach.call(e.querySelectorAll('div[draggable=false][style*="text-align: center"]'),L.DomUtil.remove)}}}},_roadRegexp:/!1i(\d+)!2i(\d+)!3i(\d+)!/,_satRegexp:/x=(\d+)&y=(\d+)&z=(\d+)/,_staticRegExp:/StaticMapService\.GetMapImage/,_onMutatedImage:function(t){var n,e=t.src.match(this._roadRegexp),s=0;if(e){n={z:e[1],x:e[2],y:e[3]};if(this._imagesPerTile>1){t.style.zIndex=1;s=1}}
else{e=t.src.match(this._satRegexp);if(e){n={x:e[1],y:e[2],z:e[3]}};s=0};if(n){var a=this._tileCoordsToKey(n);t.style.position='absolute';t.style.visibility='hidden';var i=a+'/'+s;this._freshTiles[i]=t;if(i in this._tileCallbacks&&this._tileCallbacks[i]){this._tileCallbacks[i].pop()(t);if(!this._tileCallbacks[i].length){delete this._tileCallbacks[i]}}
else{if(this._tiles[a]){var o=this._tiles[a].el,r=(s===0)?o.firstChild:o.firstChild.nextSibling,l=this._clone(t);o.replaceChild(l,r)}}}
else if(t.src.match(this._staticRegExp)){t.style.visibility='hidden'}},createTile:function(t,e){var a=this._tileCoordsToKey(t),i=L.DomUtil.create('div');i.dataset.pending=this._imagesPerTile;e=e.bind(this,null,i);for(var s=0;s<this._imagesPerTile;s++){var n=a+'/'+s;if(n in this._freshTiles){var o=this._freshTiles[n];i.appendChild(this._clone(o));i.dataset.pending--}
else{this._tileCallbacks[n]=this._tileCallbacks[n]||[];this._tileCallbacks[n].push((function(t){return function(i){t.appendChild(this._clone(i));t.dataset.pending--;if(!parseInt(t.dataset.pending)){e()}}.bind(this)}.bind(this))(i))}};if(!parseInt(i.dataset.pending)){L.Util.requestAnimFrame(e)};return i},_clone:function(t){var e=t.cloneNode(!0);e.style.visibility='visible';return e},_checkZoomLevels:function(){var e=this._map.getZoom(),t=this._mutant.getZoom();if(!e||!t)return;if((t!==e)||(t>this.options.maxNativeZoom)){this._setMaxNativeZoom(t)}},_setMaxNativeZoom:function(t){if(t!=this.options.maxNativeZoom){this.options.maxNativeZoom=t;this._resetView()}},_reset:function(){this._initContainer()},_update:function(){if(this._mutant){var e=this._map.getCenter(),s=new google.maps.LatLng(e.lat,e.lng);this._mutant.setCenter(s);var t=this._map.getZoom(),i=t!==Math.round(t),n=this._mutant.getZoom();if(!i&&(t!=n)){this._mutant.setZoom(t);if(this._mutantIsReady)this._checkZoomLevels()}};L.GridLayer.prototype._update.call(this)},_resize:function(){var t=this._map.getSize();if(this._mutantContainer.style.width===t.x&&this._mutantContainer.style.height===t.y)return;this.setElementSize(this._mutantContainer,t);if(!this._mutant)return;google.maps.event.trigger(this._mutant,'resize')},_handleZoomAnim:function(){if(!this._mutant)return;var t=this._map.getCenter(),e=new google.maps.LatLng(t.lat,t.lng);this._mutant.setCenter(e);this._mutant.setZoom(Math.round(this._map.getZoom()))},_removeTile:function(t){if(!this._mutant)return;setTimeout(this._pruneTile.bind(this,t),1000);return L.GridLayer.prototype._removeTile.call(this,t)},_pruneTile:function(t){var l=this._mutant.getZoom(),h=t.split(':')[2],n=this._mutant.getBounds(),s=n.getSouthWest(),o=n.getNorthEast(),m=L.latLngBounds([[s.lat(),s.lng()],[o.lat(),o.lng()]]);for(var e=0;e<this._imagesPerTile;e++){var i=t+'/'+e;if(i in this._freshTiles){var a=this._map&&this._keyToBounds(t),r=this._map&&a.overlaps(m)&&(h==l);if(!r)delete this._freshTiles[i]}}}});L.gridLayer.googleMutant=function(t){return new L.GridLayer.GoogleMutant(t)};