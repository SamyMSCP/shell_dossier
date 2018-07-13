<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 30/01/2018
 * Time: 14:13
 */
/*
?>
<select v-else-if="(($store.state.transactions.selectedTransaction.docs[9].length > 0))"
		class="form-control select-status"
		v-model="$store.state.transactions.selectedTransaction.status_trans" @click="change_selected">
	<template v-for="(status, keys) in $store.state.transactions.lstStatusTransaction">
		<option v-for="(statu, key) in status" :value="keys + '-' + key">{{ keys + '-' + key
			+ ' ' + statu.title }}
		</option>
	</template>
</select>
<?php //*/ ?>
<div>
	<div class="status-transaction text-center">
		<select class="form-control" v-model="selected" @change="set_selected">
			<template v-for="(status, keys) in $store.state.transactions.lstStatusTransaction">
				<option v-for="(statu, key) in status" :value="keys + '-' + key">{{ keys + '-' + key
					+ ' ' + statu.title }}
				</option>
			</template>
		</select>
	</div>
</div>
