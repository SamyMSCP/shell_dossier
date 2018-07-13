</script>

<script type="text/x-template" id="ckEditorTemplate">
	<div class="ckeditor">
		<textarea :id="id" :value="value"></textarea>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component (
	'ckEditor',
	{
		template: "#ckEditorTemplate",
		props: {
			value: {
				type: String
			},
			id: {
				type: String,
				default: 'editor',
				required: true
			},
			height: {
				type: String,
				default: '400px',
			},
			toolbar: {
				type: Array,
				default: () => [
					['Format', 'FontSize'],
					['Cut','Copy', 'Paste', 'PasteText'],
					['Bold', 'Italic'],
					['Undo', 'Redo'],
					['Link', 'Unlink'],
					['Image', 'Table', 'HorizontalRule'],
					['NumberedList', 'BulletedList', '-', 'Outdent', 'Blockquote'],
					[ 'JustifyLeft', 'JustifyCenter','JustifyRight', 'JustifyBlock' ],
					[ 'TextColor', 'BGColor' ]
				]
			},
			language: {
				type: String,
				default: 'fr'
			},
			extraplugins: {
				type: String,
				default: ''
			}
		},
		data: function() {
			return({outter: false})
		},
		beforeUpdate: function () {
			const ckeditorId = this.id
			if (this.value !== CKEDITOR.instances[ckeditorId].getData()) {
				this.outter = true;
				CKEDITOR.instances[ckeditorId].setData(this.value)
				this.outter = false;
			}
		},
		mounted: function () {
			const ckeditorId = this.id
			const ckeditorConfig = {
				toolbar: this.toolbar,
				language: this.language,
				height: this.height,
				extraPlugins: this.extraplugins
			}
			CKEDITOR.replace(ckeditorId, ckeditorConfig)
			CKEDITOR.instances[ckeditorId].setData(this.value)
			CKEDITOR.instances[ckeditorId].on('change', () => {
				let ckeditorData = CKEDITOR.instances[ckeditorId].getData()
				if (ckeditorData !== this.value && !this.outter) {
					this.$emit('input', ckeditorData)
					this.$emit('change', ckeditorData)
				}
			})
		},
		destroyed: function () {
			const ckeditorId = this.id
	
			if (CKEDITOR.instances[ckeditorId]) {
				CKEDITOR.instances[ckeditorId].destroy()
			}
		}
	}
);
