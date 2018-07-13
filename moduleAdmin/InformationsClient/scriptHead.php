</script>
<script type="text/javascript" charset="utf-8">

Vue.component(
	'crmLastDate',
	{
		data: function() {
			return (myCrmStore);
		},
		template: `
			<span>{{lastCrmDateExecution | tsDate}}</span>
		`,
		computed:{
			lastCrmDateExecution: function () {
				that = this;
				var rt = that.listCrm.filter(function(elm) {
					return (elm.isOkay == '1');
				}).sort(function(a, b) {
					return (b.date_end - a.date_end);
				});
				if (rt.length > 0)
					return rt[0].date_end;
				return (0);
			}
		}
	}
);

Vue.component(
	'crmNextDate',
	{
		data: function() {
			return (myCrmStore);
		},
		template: `
			<span>{{lastCrmDateExecution | tsDate}}</span>
		`,
		computed:{
			lastCrmDateExecution: function () {
				that = this;
				var rt = that.listCrm.filter(function(elm) {
					return (elm.isOkay == '0');
				}).sort(function(a, b) {
					return (a.date_execution - b.date_execution);
				});
				if (rt.length > 0)
					return rt[0].date_execution;
				return (0);
			}
		}
	}
);
