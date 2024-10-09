package models;

public class Donor extends Person {
    private double donationAmount;

    public Donor(String name, double donationAmount) {
        super(name);
        this.donationAmount = donationAmount;
    }

    @Override
    public void displayInfo() {
        super.displayInfo();
        System.out.println("Donation Amount: " + donationAmount);
    }
}
