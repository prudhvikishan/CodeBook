

<?= form_open() ?>

<h2></h2>
<label>Count :<input type="text" size="2" name="count" id="count" /> </label>
<br/>
<label>Expiration Date(YYYY-MM-DD) :
	<input type="text" name="expDate" id="expDate"/>
</label>
<br/>
<input type='submit' name='generate' value='Generate' />
<?= "</form>" ?>
<?php if($this->codes != null){?>
Codes :
<?php foreach ($this->codes as $code){ ?>
	<?php echo $code ?> </br>
<?php }}?>