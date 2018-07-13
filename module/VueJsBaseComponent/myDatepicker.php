</script>

<script type="text/x-template" id="myDatepicketTemplate">
	<input  :id="id" :value="getDateFormat" type="text" class="form-control" @change="$emit('change')"/>
</script>

<script type="text/javascript" charset="utf-8">

Vue.component(
	'myDatepicker',
	{
		props: {
			value: {
				default: 0
			},
			id : {
				type: String,
				default: "myDatePicker"
			}
		},
		template: '#myDatepicketTemplate',
		computed: {
			getDateFormat:function () {
				if (this.value == 0)
					return ("-");
				return (moment(this.value, "X").format('DD/MM/YYYY'))
			}
		},
		mounted: function() {
			var that = this;
			$("#" + this.id).datepicker({
				onClose: function(e) {
					var newDate = moment(e, "DD/MM/YYYY")
					var rt = moment(that.value, "X");
					if (
						newDate.date() != rt.date() ||
						newDate.month() != rt.month() ||
						newDate.year() != rt.year()
					)
					{
						rt.set({
							date: newDate.date(),
							month: newDate.month(),
							year: newDate.year(),
							hour: 0,
							minute: 0,
							second: 0,
							millisecond: 0
						});
						that.$emit('change');
						that.$emit('input', parseInt(rt.clone().format("X")));
					}
				},
				dateFormat: 'dd/mm/yy',
				changeMonth: true,
				changeYear: true,
			})
		}
	}
);
