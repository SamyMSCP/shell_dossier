</script>
<script>
//Finance.js
//For more information, visit http://financejs.org
//Copyright 2014 - 2015 Essam Al Joubori, MIT license

// Instantiate a Finance class
var Finance = function() {};

// Present Value (PV)
Finance.prototype.PV = function (rate, cf1, numOfPeriod) {
    numOfPeriod = typeof numOfPeriod !== 'undefined' ? numOfPeriod : 1;
    var rate = rate/100, pv;
    pv = cf1 / Math.pow((1 + rate),numOfPeriod);
    return Math.round(pv * 100) / 100;
};

// Future Value (FV)
Finance.prototype.FV = function (rate, cf0, numOfPeriod) {
    var rate = rate/100, fv;
    fv = cf0 * Math.pow((1 + rate), numOfPeriod);
    return Math.round(fv * 100) / 100;
};

// Net Present Value (NPV)
Finance.prototype.NPV = function (rate) {
    var rate = rate/100, npv = arguments[1];
    for (var i = 2; i < arguments.length; i++) {
        npv +=(arguments[i] / Math.pow((1 + rate), i - 1));
    }
    return Math.round(npv * 100) / 100;
};

// seekZero seeks the zero point of the function fn(x), accurate to within x \pm 0.01. fn(x) must be decreasing with x.
function seekZero(fn) {
    var x = 1;
    while (fn(x) > 0) {
        x += 1;
    }
    while (fn(x) < 0) {
        x -= 0.01
    }
    return x + 0.01;
}

// Internal Rate of Return (IRR)
Finance.prototype.IRR = function(cfs) {
    var args = arguments;
    var numberOfTries = 1;
    // Cash flow values must contain at least one positive value and one negative value
    var positive, negative;
    Array.prototype.slice.call(args).forEach(function (value) {
        if (value > 0) positive = true;
        if (value < 0) negative = true;
    })
    //if (!positive || !negative) throw new Error('IRR requires at least one positive value and one negative value');
    function npv(rate) {
        numberOfTries++;
        if (numberOfTries > 1000) {
            //throw new Error('IRR can\'t find a result');
        }
        var rrate = (1 + rate/100);
        var npv = args[0];
        for (var i = 1; i < args.length; i++) {
            npv += (args[i] / Math.pow(rrate, i));
        }
        return npv;
    }
    return Math.round(seekZero(npv) * 100) / 100;
};

// Payback Period (PP)
Finance.prototype.PP = function(numOfPeriods, cfs) {
    // for even cash flows
    if (numOfPeriods === 0) {
        return Math.abs(arguments[1]) / arguments[2];
    }
    // for uneven cash flows
    var cumulativeCashFlow = arguments[1];
    var yearsCounter = 1;
    for (i = 2; i < arguments.length; i++) {
        cumulativeCashFlow += arguments[i];
        if (cumulativeCashFlow > 0) {
            yearsCounter += (cumulativeCashFlow - arguments[i]) / arguments[i];
            return yearsCounter;
        } else {
            yearsCounter++;
        }
    }
};

// Return on Investment (ROI)
Finance.prototype.ROI = function(cf0, earnings) {
    var roi = (earnings - Math.abs(cf0)) / Math.abs(cf0) * 100;
    return Math.round(roi * 100) / 100;
};

// Amortization
Finance.prototype.AM = function (principal, rate, period, yearOrMonth, payAtBeginning) {
    var numerator, denominator, am;
    var ratePerPeriod = rate / 12 / 100;

    // for inputs in years
    if (!yearOrMonth) {
        numerator = buildNumerator(period * 12);
        denominator = Math.pow((1 + ratePerPeriod), period * 12) - 1;

        // for inputs in months
    } else if (yearOrMonth === 1) {
        numerator = buildNumerator(period)
        denominator = Math.pow((1 + ratePerPeriod), period) - 1;

    } else {
        console.log('not defined');
    }
    am = principal * (numerator / denominator);
    return Math.round(am * 100) / 100;

    function buildNumerator(numInterestAccruals){
        if( payAtBeginning ){
            //if payments are made in the beginning of the period, then interest shouldn't be calculated for first period
            numInterestAccruals -= 1;
        }
        return ratePerPeriod * Math.pow((1 + ratePerPeriod), numInterestAccruals);
    }
};

// Profitability Index (PI)
Finance.prototype.PI = function(rate, cfs){
    var totalOfPVs = 0, PI;
    for (var i = 2; i < arguments.length; i++) {
        var discountFactor;
        // calculate discount factor
        discountFactor = 1 / Math.pow((1 + rate/100), (i - 1));
        totalOfPVs += arguments[i] * discountFactor;
    }
    PI = totalOfPVs/Math.abs(arguments[1]);
    return Math.round(PI * 100) / 100;
};

// Discount Factor (DF)
Finance.prototype.DF = function(rate, numOfPeriods) {
    var dfs = [], discountFactor;
    for (var i = 1; i < numOfPeriods; i++) {
        discountFactor = 1 / Math.pow((1 + rate/100), (i - 1));
        roundedDiscountFactor = Math.ceil(discountFactor * 1000)/1000;
        dfs.push(roundedDiscountFactor);
    }
    return dfs;
};

// Compound Interest (CI)
Finance.prototype.CI = function(rate, numOfCompoundings, principal, numOfPeriods) {
    var CI = principal * Math.pow((1 + ((rate/100)/ numOfCompoundings)), numOfCompoundings * numOfPeriods);
    return Math.round(CI * 100) / 100;
};

// Compound Annual Growth Rate (CAGR)
Finance.prototype.CAGR = function(beginningValue, endingValue, numOfPeriods) {
    var CAGR = Math.pow((endingValue / beginningValue), 1 / numOfPeriods) - 1;
    return Math.round(CAGR * 10000) / 100;
};

// Leverage Ratio (LR)
Finance.prototype.LR = function(totalLiabilities, totalDebts, totalIncome) {
    return (totalLiabilities  + totalDebts) / totalIncome;
};

// Rule of 72
Finance.prototype.R72 = function(rate) {
    return 72 / rate;
};

// Weighted Average Cost of Capital (WACC)
Finance.prototype.WACC = function(marketValueOfEquity, marketValueOfDebt, costOfEquity, costOfDebt, taxRate) {
    E = marketValueOfEquity;
    D = marketValueOfDebt;
    V =  marketValueOfEquity + marketValueOfDebt;
    Re = costOfEquity;
    Rd = costOfDebt;
    T = taxRate;

    var WACC = ((E / V) * Re/100) + (((D / V) * Rd/100) * (1 - T/100));
    return Math.round(WACC * 1000) / 10;
};

// PMT calculates the payment for a loan based on constant payments and a constant interest rate
Finance.prototype.PMT = function(fractionalRate, numOfPayments, principal) {
    return -principal * fractionalRate/(1-Math.pow(1+fractionalRate,-numOfPayments))
};

// IAR calculates the Inflation-adjusted return
Finance.prototype.IAR = function(investmentReturn, inflationRate){
    return 100 * (((1 + investmentReturn) / (1 + inflationRate)) - 1);
}

// XIRR - IRR for irregular intervals
Finance.prototype.XIRR = function(cfs, dts, guess) {
    if (cfs.length != dts.length) throw new Error('Number of cash flows and dates should match');

    var positive, negative;
    Array.prototype.slice.call(cfs).forEach(function (value) {
        if (value > 0) positive = true;
        if (value < 0) negative = true;
    });

    if (!positive || !negative) throw new Error('XIRR requires at least one positive value and one negative value');


    guess = !!guess ? guess : 0;

    var limit = 100; //loop limit
    var guess_last;
    var durs = [];

    durs.push(0);

    //Create Array of durations from First date
    for(var i = 1; i < dts.length; i++) {
        durs.push(durYear(dts[0], dts[i]));
    }

    do {
        guess_last = guess;
        guess = guess_last - sumEq(cfs, durs, guess_last);
        limit--;

    }while(guess_last.toFixed(5) != guess.toFixed(5) && limit > 0);

    var xirr = guess_last.toFixed(5) != guess.toFixed(5) ? null : guess*100;

    return Math.round(xirr * 100) / 100;
};

//Returns Sum of f(x)/f'(x)
function sumEq(cfs, durs, guess) {
    var sum_fx = 0;
    var sum_fdx = 0;
    for (var i = 0; i < cfs.length; i++) {
        sum_fx = sum_fx + (cfs[i] / Math.pow(1 + guess, durs[i]));
    }
    for ( i = 0; i < cfs.length; i++) {
        sum_fdx = sum_fdx + (-cfs[i] * durs[i] * Math.pow(1 + guess, -1 - durs[i]));
    }
    return sum_fx / sum_fdx;
}

//Returns duration in years between two dates
function durYear(first, last) {
    return (Math.abs(last.getTime() - first.getTime()) / (1000 * 3600 * 24 * 365));
}

if (typeof exports !== 'undefined') {
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = Finance;
        module.exports.Finance = Finance;
    }
}

</script>
<script type="text/javascript" charset="utf-8">
	store.registerModule('opportunite', {
		state: {
			lst: <?= json_encode($this->lstOpportunite) ?>,
            all: <?= json_encode($this->all) ?>,
			current_op: {url: "",ok:0},
			currentPage: 0,
			scpiFilter: 0,
			dureeFilter: 0,
			typeFilter: 0,
			validatedFilter: 1,
			nbrPages: 0,
			token: "<?=$_SESSION['csrf'][0]?>",
            nom_Scpi: 'scpi',
            irr_Avant_Basse:0,
            irr_Avant_Moyen:0,
            irr_Avant_Haute:0,
            irr_Apres_Basse:0,
            irr_Apres_Moyen:0,
            irr_Apres_Haute:0,

		},
		mutations: {
			SET_CURRENT_OP: function (state, data) {

				state.current_op = data;
				$("#op_modal").modal("show");

			},
			SET_OPPORTUNITY_PAGE: function(state, data) {
				state.currentPage = data;
			},
			SET_OPPORTUNITY_PREVIOUSPAGE: function (state, data) {
				state.currentPage--;
				if (state.currentPage < 0)
					state.currentPage = state.nbrPages - 1;
			},
			SET_OPPORTUNITY_NEXTPAGE: function (state, data) {
				state.currentPage++;
				if (state.currentPage >= state.nbrPages)
					state.currentPage = 0;
			},

            irr_Avant_Basse: function (state,data) {
                var finance = new Finance();
                var contientvaleur = [(-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2))];
                for (var i = 0; i < state.current_op.time_demembrement; i++) {
                    contientvaleur.push(((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100)/4.5)*4.25)
                }

                state.irr_Avant_Basse = finance.IRR.apply(this,contientvaleur);
            },
            irr_Avant_Moyen: function (state,data) {
                var finance = new Finance();
                var contientvaleur = [(-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2))];
                for (var i = 0; i < state.current_op.time_demembrement; i++) {
                    contientvaleur.push((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100))
                }

                state.irr_Avant_Moyen = finance.IRR.apply(this,contientvaleur);
            },
            irr_Avant_Haute: function (state,data) {
                var finance = new Finance();
                var contientvaleur = [(-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2))];
                for (var i = 0; i < state.current_op.time_demembrement; i++) {
                    contientvaleur.push(((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100)/4.5)*4.75)
                }

                state.irr_Avant_Haute = finance.IRR.apply(this,contientvaleur);
            },
            irr_Apres_Basse: function (state,data) {
                var finance = new Finance();
                var contientvaleur = [(-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2))];
                for (var i = 0; i < state.current_op.time_demembrement; i++) {
                    contientvaleur.push(((4.25 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + (-((4.25 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + ((-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2)) / state.current_op.time_demembrement) ) * 0.3333)))
                }

                state.irr_Apres_Basse = finance.IRR.apply(this,contientvaleur);
            },
            irr_Apres_Moyen: function (state,data) {
                var finance = new Finance();
                var contientvaleur = [(-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2))];
                for (var i = 0; i < state.current_op.time_demembrement; i++) {
                    contientvaleur.push(((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + (-((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + ((-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2)) / state.current_op.time_demembrement) ) * 0.3333)))
                }

                state.irr_Apres_Moyen = finance.IRR.apply(this,contientvaleur);
            },
            irr_Apres_Haute: function (state,data) {
                var finance = new Finance();
                var contientvaleur = [(-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2))];
                for (var i = 0; i < state.current_op.time_demembrement; i++) {
                    contientvaleur.push(((4.75 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + (-((4.75 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + ((-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2)) / state.current_op.time_demembrement) ) * 0.3333)))
                }

                state.irr_Apres_Haute = finance.IRR.apply(this,contientvaleur);
            },

            Name: function (state, data) {
                if(typeof store.getters.getScpi(state.current_op.id_scpi) == 'undefined'){
                    state.nom_Scpi=" ";
                }
                else state.nom_Scpi=store.getters.getScpi(state.current_op.id_scpi).name;
            }


		},
		actions: {
			SET_OPPORTUNITE_INTEREST: function(context, data) {
				Vue.http.post('ajax_request_client.php',{
						req: "OpportunitySet",
						action: "interrest",
						data: {
							id: data.id
						},
						token: context.state.token
					},
					{emulateJSON: true}
				).then(
					function (res){
						msgBox.show("Votre conseiller a été informé de votre intérêt pour cette opportunité et vous contacteras dans les plus brefs délais.");
						$("#op_modal").modal("hide");
					},
					function (res) {
						context.token = res.body.token;
						if (typeof res.body.err !== 'undefined')
							msgBox.show(res.body.err);
						else
							msgBox.show("Une erreur s'est produite. Essayer de rafraichir la page et de réessayer");
						$("#op_modal").modal("hide");
					}
				);
			}
		},
		getters: {
			getOpportuniyNbrPages: function(state, getters) {
				state.nbrPages = parseInt(getters.getFilteredOpportunite.length / 3);
				if (getters.getFilteredOpportunite.length % 3)
					state.nbrPages++;
				return (state.nbrPages);
			},
            recup_op: function (state){
                return state.current_op;
            },
			getFilteredOpportunite: function(state, getters) {
				return (state.lst.filter(function(elm) {
					if (state.validatedFilter == 1 && elm.validated == false)
						return (false);
					if (state.scpiFilter != -1 && state.scpiFilter != 0 && elm.id_scpi != state.scpiFilter)
						return (false);
					if (state.dureeFilter != 0 && elm.time_demembrement != state.dureeFilter)
						return (false);
					if (state.typeFilter != 0 && elm.type == 1 && state.typeFilter == 2)
						return (false);
					if (state.typeFilter != 0 && elm.type == 0 && state.typeFilter == 1)
						return (false);
					return (true);
				}));
			},
			getOpportuniteAtCurrentPage: function(state, getters) {
				var rt = [];
				var i = 0;
				if (state.currentPage >= state.nbrPages)
					state.currentPage = state.nbrPages  - 1;
				if (state.currentPage < 0)
					state.currentPage = 0;
				while (i < 3)
				{
					var current = (state.currentPage * 3) + i;
					if (typeof state.lst[current] == "undefined")
						break ;
					rt.push(getters.getFilteredOpportunite[current]);
					i++;
				}
				return (rt);
			},
			getOpportuniteAtPage: function(state, getters) {
				return (function (page) {
					var rt = [];
					var i = 0;
					while (i < 3)
					{
						var current = (page * 3) + i;
						if (typeof getters.getFilteredOpportunite[current] == "undefined")
							break ;
						rt.push(getters.getFilteredOpportunite[current]);
						i++;
					}
					return (rt);
				})
			},

            tdvm: function (state, getters){

			    return (function (id) {
                    var i=0;
                    var res;
                    for( i in state.all){
                        if(state.all[i].id ==id){
                            res=state.all[i].Tdvm;
                        }
                    }
                    return res;
                })


            },


            pageUrl: function(state,getters) {
			    //console.log(store.getters.getScpi(state.current_op.id_scpi));
                //store.commit('irr',(-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100))))),((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100)/4.5)*4.25,state.current_op.time_demembrement);
                console.log("Tdvm : ", getters.tdvm(state.current_op.id_scpi));
                //console.log(state.all);
                store.commit('irr_Avant_Basse');
                store.commit('irr_Avant_Moyen');
                store.commit('irr_Avant_Haute');
                store.commit('irr_Apres_Basse');
                store.commit('irr_Apres_Moyen');
                store.commit('irr_Apres_Haute');
                store.commit('Name');
                return 'index.php?p=SimuPdf'
                    +'&nom_Scpi='+state.nom_Scpi
                    +'&duree_Demembrement='+state.current_op.time_demembrement
                    +'&prix_Part='+state.current_op.price_per_part
                    +'&montant_Global_Investissement='+(state.current_op.nb_part*state.current_op.price_per_part).toFixed(2)
                    +'&montant_Nue_Propriete='+(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)).toFixed(2)
                    +'&cle_Repartition_Nue_Propriete='+state.current_op.key_nue
                    +'&cle_Repartition_usufruit='+(100-state.current_op.key_nue)
                    +'&montant_Usufruit='+((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100))).toFixed(2)
                    +'&montant_Usufruit_negatif='+(-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2))
                    +'&nombre_Parts='+state.current_op.nb_part
                    +'&tdvm_Previsionnel=4.5'
                    +'&dividende_Annuel='+(4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100)
                    +'&acompte_Trimestriel='+((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100)/4/state.current_op.nb_part)
                    +'&dividende_Annuel_Part='+(((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100)/4/state.current_op.nb_part)*4)
                    +'&flux_Avant_Fiscalite='+(4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100)
                    +'&amortissement_Usufruit='+((-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2)) / state.current_op.time_demembrement)
                    +'&is_A_Payer='+(-((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + ((-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2)) / state.current_op.time_demembrement) ) * 0.3333)
                    +'&flux_Apres_Fiscalite='+((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + (-((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + ((-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2)) / state.current_op.time_demembrement) ) * 0.3333))
                    +'&hypothese_Medium='+getters.tdvm(state.current_op.id_scpi)*0.9
                    +'&hypothese_Basse='+getters.tdvm(state.current_op.id_scpi)*0.9*0.9
                    +'&hypothese_Haute='+getters.tdvm(state.current_op.id_scpi)
                    +'&acompte_Trimestriel_Basse='+((((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100)/4/state.current_op.nb_part)/4.5)*4.25)
                    +'&acompte_Trimestriel_Haute='+((((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100)/4/state.current_op.nb_part)/4.5)*4.75)
                    +'&dividende_Annuel_Part_Haute='+(((((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100)/4/state.current_op.nb_part)*4)/4.5)*4.75)
                    +'&dividende_Annuel_Part_Basse='+(((((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100)/4/state.current_op.nb_part)*4)/4.5)*4.25)
                    +'&irr_Avant_Basse='+state.irr_Avant_Basse
                    +'&irr_Avant_Medium='+state.irr_Avant_Moyen
                    +'&irr_Avant_Haute='+state.irr_Avant_Haute
                    +'&irr_Apres_Basse='+state.irr_Apres_Basse
                    +'&irr_Apres_Medium='+state.irr_Apres_Moyen
                    +'&irr_Apres_Haute='+state.irr_Apres_Haute
                    +'&gain_Net_Basse='+((-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2)) + (((4.25 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + (-((4.25 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + ((-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2)) / state.current_op.time_demembrement) ) * 0.3333)) * state.current_op.time_demembrement))
                    +'&gain_Net_Medium='+((-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2)) + (((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + (-((4.5 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + ((-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2)) / state.current_op.time_demembrement) ) * 0.3333)) * state.current_op.time_demembrement))
                    +'&gain_net_Haute='+((-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2)) + (((4.75 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + (-((4.75 * (state.current_op.nb_part*state.current_op.price_per_part).toFixed(2) / 100) + ((-(((state.current_op.nb_part*state.current_op.price_per_part)-(state.current_op.nb_part*state.current_op.price_per_part*(state.current_op.key_nue/100)))).toFixed(2)) / state.current_op.time_demembrement) ) * 0.3333)) * state.current_op.time_demembrement))
                 ;
            }
		}
	});
