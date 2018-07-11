/*global jQuery:false, WP_OPAL_Registry:false, _:false,console:false,wp:false,jBox:false*/
window.WP_OPAL_Registry = (function() {
	"use strict";
	var modules = {};

	/**
	 * Test module
	 * @param module
	 * @returns {boolean}
	 * @private
	 */
	function _testModule(module) {
		if (module.getInstance && typeof module.getInstance === 'function') {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Register module
	 * @param name
	 * @param module
	 */
	function register(name, module) {
		if (_testModule(module)) {
			modules[name] = module;
		} else {
			throw new Error('Invalide module "' + name + '". The function "getInstance" is not defined.');
		}
	}



	/**
	 * Unregister
	 * @param name
	 */
	function unregister(name) {
		delete modules[name];
	}

	/**
	 * Get instance module
	 * @param name
	 * @returns {*|wp.mce.View}
	 */
	function _get(name) {
		var module = modules[name];
		if (!module) {
			throw new Error('The module "' + name + '" has not been registered or it was unregistered.');
		}

		if (typeof module.getInstance !== 'function') {
			throw new Error('The module "' + name + '" can not be instantiated. ' + 'The function "getInstance" is not defined.');
		}

		return modules[name].getInstance();
	}

	return {
		register: register,
		unregister: unregister,
		_get: _get,
	};

})();

/**
 * Category module
 */

WP_OPAL_Registry.register("Medical-Department", (function($) {
	"use strict";
	var state;

	function createInstance() {
		return {
			init: function() {
				$('#IconPicker').fontIconPicker({
					source: $.fnt_icons_categorized,
					emptyIcon: true,
					hasSearch: true
				}).on('change', function() {
					//console.log($(this));
				});

				// remove icon
				$('.remove_icon_button').on('click', function() {
					$(this).siblings('.mprm_icon_p').find('input').attr({'value': ''});
				});

				$('.upload_image_button').on('click', function() {
					state.openUploadWindow();
					return false;
				});

				$('.remove_image_button').on('click', function() {
					$('#menu_category_thumbnail img').attr('src', $('#menu_category_thumbnail img').attr('data-placeholder'));
					$('#menu_category_thumbnail_id').val('');
					$('.remove_image_button').hide();
					return false;
				});
			},
			/**
			 * Open upload window
			 *
			 * @returns {undefined}
			 */
			openUploadWindow: function() {
				if (this.window === undefined) {
					// Create the media frame.
					this.window = wp.media.frames.downloadable_file = wp.media({
						title: 'Choose an image',
						button: {
							text: 'Select'
						},
						multiple: false
					});
					var self = this;
					// When an image is selected, run a callback.
					this.window.on('select', function() {
						var attachment = self.window.state().get('selection').first().toJSON();
						$('#menu_category_thumbnail_id').val(attachment.id);
						$('#menu_category_thumbnail img').attr('src', attachment.sizes.thumbnail.url);
						$('.remove_image_button').show();
					});
				}
				// Finally, open the modal.
				this.window.open();
			}
		};
	}

	return {
		getInstance: function() {
			if (!state) {
				state = createInstance();
			}
			return state;
		}
	};
})(jQuery));



(function($) {
	"use strict";
	$(document).ready(function() {
		// if edit and add menu_category
		if ('edit-opal_department' === window.pagenow) {
			WP_OPAL_Registry._get("Medical-Department").init();
		}

	/**
		* --- Event onChange for image select
		*/
		if($('#service_image_size').val() == "other"){
			$('.cmb2-id-service-other-size').show();
		}else{
			$('.cmb2-id-service-other-size').hide();
		}

		//--------------
		$('#service_image_size').on('change', function(){
			var valselected = this.value;
			if (valselected == "other") {
				$('.cmb2-id-service-other-size').show();
			}else{
				$('.cmb2-id-service-other-size').hide();
			}
		});

	/**
		* --- Event onChange for image select
		*/
		if($('#doctor_image_size').val() == "other"){
			$('.cmb2-id-doctor-other-size').show();
		}else{
			$('.cmb2-id-doctor-other-size').hide();
		}

		//--------------
		$('#doctor_image_size').on('change', function(){
			var valselected = this.value;
			if (valselected == "other") {
				$('.cmb2-id-doctor-other-size').show();
			}else{
				$('.cmb2-id-doctor-other-size').hide();
			}
		});

	/**
	* --- Event onChange for status Sunday post type Sevice
	*/
	if($('#opal_service_sunday').val() == "open"){
		$('.sunday_from').show();
		$('.sunday_to').show();
	}else{
		$('.sunday_from').hide();
		$('.sunday_to').hide();
	}

	//--------------
	$('#opal_service_sunday').on('change', function(){
		var valselected = this.value;
		if (valselected == "open") {
			$('.sunday_from').show();
			$('.sunday_to').show();
		}else{
			$('.sunday_from').hide();
			$('.sunday_to').hide();
		}
	});
});

}(jQuery));


