<h3 class="page-header">Rewards</h3>
<?php if ($this->session->flashdata("success")) { ?>
<div class="row">
	<div class="col-md-12">

		<div class="alert alert-success">
			<?php echo $this->session->flashdata("success"); ?>
		</div>

	</div>
</div>
<?php } else if($this->session->flashdata("error")) { ?>
<div class="row">
	<div class="col-md-12">

		<div class="alert alert-danger">
			<?php echo $this->session->flashdata("error"); ?>
		</div>

	</div>
</div>
<?php } ?>

<div class="row">

	<div class="col-sm-6 reward-history">
		<h5><a href="#">Rewards History</a></h5>
	</div>

	<div class="col-sm-6 coin-balance">
		<h5>Coin Balance: <i class="fa fa-fw fa-plus-circle"></i><?= $this->user->getGoldCoinCount(); ?></h5>
	</div>

</div>

<div class="row">
	<div class="col-md-12">
		<section class="block rewards-block">
			<h4>Available Rewards</h4>
			<div class="body">
				<ul class="reward-container">
				<?php foreach($this->allRewards as $reward): ?>
					<li>
						<div class="row">
							<div class="col-sm-9">
								<div class="reward-info">
									<div class="reward-image">
										<img src="<?= base_url(); ?><?= $reward->image; ?>" alt="reward" />
									</div>
									<div class="reward-description">
										<h5><?= $reward->name; ?></h5>
										<?= $reward->description; ?>
									</div>
								</div>
							</div>
							<div class="col-sm-3">

								<div class="row reward-redemption">
									<div class="col-sm-12">
										<div class="coins">
											<i class="fa fa-fw fa-plus-circle"></i><span class="coin-count"><?= $reward->cost; ?></span>
										</div>
									</div>
									<div class="col-sm-12">
										<?php if($reward->cost > $this->user->getGoldCoinCount()) { ?>
											<a href="#" data-reward="<?= $reward->reward_id; ?>" class="btn btn-secondary btn-block btn-redeem disabled">Redeem</a>
										<?php } else { ?>
											<a href="#" data-reward="<?= $reward->reward_id; ?>" class="btn btn-secondary btn-block btn-redeem">Redeem</a>
										<?php } ?>
									</div>
								</div>

							</div>
						</div>

					</li>

				<?php endforeach; ?>
				</ul>
			</div>
		</section>
	</div>
</div>

<script>

$(document).ready(function() {

	$(".btn-redeem").on('click', function() {

		var bootboxMessage = "";
		bootboxMessage += "<div class='row mb'>";

		
		bootboxMessage += "<div class='col-md-12'>";
		bootboxMessage += "<p>Are you sure you want to redeem " + $(this).parent().parent().find(".coin-count").text();
		bootboxMessage += " for \"" + $(this).parent().parent().find("h5").text() + "\"?";
		bootboxMessage += "</div>";
		bootboxMessage += "</div>";


		bootboxMessage += "<div class='row'>";
		bootboxMessage += "<div class='col-md-12'>";
		bootboxMessage += "<a href='<?= site_url('student/redeem_rewards/'); ?>" + "/" + $(this).data('reward') + "' class='btn btn-secondary btn-block'>Redeem</a>";
		bootboxMessage += "</div></div>";
		bootbox.dialog({
			message: bootboxMessage,
			title: "Redeem Rewards Coins"
		});

	});

});

</script>