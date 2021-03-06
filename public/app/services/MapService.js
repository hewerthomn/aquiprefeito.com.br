'use strict';
/**
 * Map Service
 *
 */
function MapService()
{
	return {

		init: function(opts)
		{
			if(google == undefined)
			{
				alert('ERRO: API do Google Maps não foi carregada. Verifique sua conexão de Internet.');
				return;
			}

			this.setup(opts);

			this.setCenterMap();
			this.fixMapHeight();
		},

		/**
   	* setup method
   	*/
	  setup: function(opts)
	  {
	    var self = this;

	    OpenLayers.Util.applyDefaults(opts, self.defaultOpts);

	    self._map = new OpenLayers.Map(opts.id, {
	    	theme: null,
	    	projection: 'EPSG:4326',
	    	displayProjection: 'EPSG:4326'
	    });

	    self._startZoom  = opts.startZoom;
	    self._startLonlat = new OpenLayers.LonLat(opts.startLonlat.lon, opts.startLonlat.lat);
	    self._offset = opts.offset | 0;

	    self._layers     = [];
	    self._baselayers = [];
	    self._controls   = [];

	    self.onSelectPoint = opts.onSelectPoint;

	    self.setupLayers();
	    self.setupControls();
	  },

	  /**
	   * setBaseLayer method
	   * @param {int} index base layer index
	   */
	  setBaseLayer: function(index)
	  {
	    this._map.setBaseLayer(this._map.layers[index]);
	  },

	  /**
	   * setBaseLayers method
	   */
	  setupLayers: function()
	  {
	    var self = this;

	    self._baselayer = {
				GOOGLE_MAP: 0
			};

			self._baselayers = [
				new OpenLayers.Layer.Google('Google Maps', {
					numZoomLevels: 19
				})
			];

			self._layers = {
				issues: new OpenLayers.Layer.Vector('Problemas', {
					styleMap: new OpenLayers.StyleMap({
						'default': {
							label: "${label}",
							labelYOffset: 27,
							fontSize: '16px',
							fontWeight: 'bold',
							externalGraphic: "${icon}",
							graphicWidth: 28
						},
						'select': {
							cursor: 'pointer'
						}
					})
				})
			};

			self._map.addLayers(self._baselayers);
			for(var key in self._layers)
			{
				self._map.addLayer(self._layers[key]);
			}
	  },

		/**
		* Retorna a lista de camadas mapa do mapa
		* @return {Array}
		*/
		getBaselayersList: function()
		{
			var self = this,
					arr = [];

			for (var key in self._baselayers)
			{
				arr.push(self._baselayers[key].name);
			};
			return arr;
		},

	  /**
		* Altera a baselayer atual a partir do indice de baselayers
		* @param {int} index
		* @return void
		*/
		setBaseLayer: function(index)
		{
			this._map.setBaseLayer(this._map.layers[index]);
		},

	  /**
	   * setControls method
	   */
	  setupControls: function()
	  {
	    var self = this;

	    self._controls = {
	      zoom: new OpenLayers.Control.Zoom(),
	      nav: new OpenLayers.Control.Navigation({
          documentDrag: true,
          dragPanOptions: { enableKinetic: true }
        }),
        selectPoint: new OpenLayers.Control.SelectFeature([self._layers.issues], {
        	toggle: true,
        	autoActivate: true,
        	onSelect: self.onSelectPoint
        })
	    };

	    for(var key in this._controls)
	    {
	      this._map.addControl(this._controls[key]);
	    }
	  },

	  /**
	   * setCenterMap method
	   * @param {OpenLayers.LonLat} point
	   * @param {int} zoom
	   */
	  setCenterMap: function(point, zoom, opts)
	  {
	  	var self = this,
	  			opts = opts || {},
	  			defaultOpts = {
	  			};

	  	if(point && !point.hasOwnProperty('CLASS_NAME') && point.CLASS_NAME !== 'OpenLayers.LonLat')
	  	{
	  		point = new OpenLayers.LonLat(point.lon, point.lat);
	  	}

	  	if(opts.hasOwnProperty('transformTo'))
	  	{
	  		point = point.transform(opts.transformTo, self._map.getProjection());
	  	}

	    self._map.setCenter(point || self._startLonlat, zoom || self._startZoom);
	  },

	  setZoom: function(zoom)
	  {
	  	this._map.setCenter(null, zoom);
	  },

		/**
		* Desenha um ponto no mapa
		* @param {Object} ponto simplificado
		* @param {Function} callback function
		*/
		addPoints: function(points, opts, callback)
		{
			var self = this,
					opts = opts || {},
					defaultOpts = {
						layer: 'issues',
						clearBefore: true,
					},
					arrPontos    = [];

			OpenLayers.Util.applyDefaults(opts, defaultOpts);

			for(var key in points)
			{
				var label = points[key].hasOwnProperty('label') ? points[key].label : '';
				var pointOpts = {
					label: label,
					icon:  points[key].icon
				};

				var point = new OpenLayers.Geometry.Point(points[key].lon, points[key].lat);
				if (opts.hasOwnProperty('transformTo'))
				{
					point = point.transform(opts.transformTo, self._map.getProjection());
				};

				var feature = new OpenLayers.Feature.Vector(point, pointOpts);
				feature.data = points[key];

				arrPontos.push(feature);
			}

			if(opts.clearBefore)
			{
				self._layers[opts.layer].destroyFeatures();
			}

			self._layers[opts.layer].addFeatures(arrPontos);

			if(typeof(callback) == 'function')
			{
				callback();
			}
		},

		/**
		* Desenha um ponto no mapa
		* @param {Object} ponto simplificado
		* @param {Object} opcoes
		* @param {Function} callback function
		*/
		addPoint: function(point, opts, callback)
		{
			var self = this;
			self.addPoints([point], opts, callback);
		},

		/**
		* onSelectFeature
		* @private
		*/
		onSelectFeature: function(feature)
		{
			var self = this;
			console.log('feature', feature);

			if(feature.geometry.id.indexOf("Point") > -1)
			{
				var lonlat = { lon: feature.data.lon, lat: feature.data.lat };
				self.onSelectPointFeature(lonlat);
			}
		},

		/**
		* onSelectPointFeature
		* @private
		*/
		onSelectPointFeature: function(feature)
		{
			return { lon: feature.data.lon, lat: feature.data.lat };
		},

		onSelectPoint: function(callback)
		{
			var self = this;
			if(!callback) return;
			self.onSelectPointFeature = callback;
		},

	  getPosition: function(callbackSuccess, callbackFailed, callbackAlways)
	  {
	  	var self = this,
	  			point;

	  	if (!self._controls.hasOwnProperty('geolocate'))
	  	{
	  		self._controls.geolocate = new OpenLayers.Control.Geolocate({
	        bind: false,
	        geolocationOption: {
	          enableHighAccuracy: true,
	          maximumAge: 0,
	          timeout: 10000
	        }
	      });

	      self._controls.geolocate.events.register('locationuncapable', this, function() {
	      	callbackAlways();
	      	callbackFailed('The device does not support Geolocation.');
	      });

	  		self._controls.geolocate.events.register('locationfailed', this, function(e) {
	  			callbackAlways();
	  			if(e.hasOwnProperty('error'))
	  			{
	  				var message = 'PositionError (Code ' + e.error.code + ')\n\n';
	  				message += e.error.message;

	  				callbackFailed(message);
	  			}
	  			else
	  			{
		      	callbackFailed('Failed to get your position.');
	  			}
		    });

		    self._controls.geolocate.events.register('locationupdated', self._controls.geolocate, function(e) {
					callbackAlways();

					var lonlat = {
						lon: e.point.x,
						lat: e.point.y
					};

		      callbackSuccess(lonlat);
		    });

		    self._map.addControl(self._controls.geolocate);
	  		self._controls.geolocate.activate();
	  	}

	  	self._controls.geolocate.getCurrentLocation();
	  },

	  getCenter: function()
	  {
	  	var self = this;
	  	var center = self._map.getCenter();

	  	return {
	  		lon: center.lon,
	  		lat: center.lat
	  	};
	  },

		getActualZoom: function(callback)
		{
			var self = this;
			self._map.events.register('zoomend', self._map, function(e) {
        var zoom = self._map.getZoom();
        callback(zoom);
      });
		},

	  clearLayer: function(layer)
	  {
	  	if(this._layers.hasOwnProperty(layer))
	  	{
	  		this._layers[layer].removeFeatures(this._layers[layer].features);
	  	}
	  },

		/**
		 * Transform latlon hash from projection to anoter
		 *
		 * @param hash lonlat with lon and lat
		 * @param string from from projection
		 * @param string to to projection
		 *
		 * @return hash hash with lon and lat properties
		 */
		transform: function(lonlat, from, to)
		{
			var dest = new OpenLayers.LonLat(lonlat.lon, lonlat.lat);
			dest = dest.transform(from, to);
			return { lon: dest.lon, lat: dest.lat };
		},

		fixMapHeight: function(offset)
		{
			var self   = this,
					height = window.innerHeight,
					element = self._map.div.id;

			if(element)
			{
				height -=  self._offset | 0;
				element = document.getElementById(element);
				element.style.height = height + 'px';
				self._map.updateSize();
			}
		}
	};
}

angular
	.module('app')
	.service('Map', MapService);
