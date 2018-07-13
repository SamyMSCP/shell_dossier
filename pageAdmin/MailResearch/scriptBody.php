</script><script>
var vm = new Vue({
	el: "#email-search",
	data: {
		searched_email: "",
		has_result: false,
		content: [
		]
	},
	methods: {
		search_mail: function () {
			var self = this;
			var em = this.searched_email;
			$.ajax({
				method: "POST",
				url: "ajax_request.php",
				data: {
					req: "AdvancedSearch",
					data: {look: "mail", content: em},
					token: "<?=$_SESSION['csrf'][0]?>"
				}
			}).done(function (msg) {
				self.content = [];
				if (msg.shortName == null)
				{
					self.has_result = false;
					return ;
				}
				var el = {
					shortname: msg.shortName,
					id: msg.id,
					url: "?p=EditionClient&client=" + msg.id,
				}
				self.content.push(el);

				self.has_result = true;
			}).error(function (msg) {
				self.has_result = false;
			});
		},
		search_phone: function () {
			var self = this;
			var em = this.searched_email;
			$.ajax({
				method: "POST",
				url: "ajax_request.php",
				data: {
					req: "AdvancedSearch",
					data: {look: "phone", content: em},
					token: "<?=$_SESSION['csrf'][0]?>"
				}
			}).done(function (msg) {
				self.content = [];
				if (msg.shortName == null)
				{
					self.has_result = false;
					return ;
				}
				var el = {
					shortname: msg.shortName,
					id: msg.id,
					url: "?p=EditionClient&client=" + msg.id,
				}
				self.content.push(el);

				self.has_result = true;
			}).error(function (msg) {
				self.has_result = false;
			});
		}
	}
});