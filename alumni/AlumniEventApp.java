package alumni;

import event.AlumniEvent;
import event.ScholarshipManager;
import models.Donor;
import models.Student;

import java.util.Scanner;

public class AlumniEventApp {
    public static void main(String[] args) {
        AlumniEvent alumniEvent = new AlumniEvent("2024 Alumni Reunion", "Sep 25, 2024", "KK Auditorium", 5);
        ScholarshipManager manager = new ScholarshipManager();

        Student student1 = new Student("Praveen", "praveen@gmail.com", 2020, "S001", 9.8, 1000.00);
        Student student2 = new Student("Raju", "raju@gmail.com", 2021, "S002", 9.9, 1500.00);
        Student student3 = new Student("Akthar", "akthar@gmail.com", 2022, "S003", 9.7, 2000.00);

        alumniEvent.addAttendee(student1);
        alumniEvent.addAttendee(student2);
        alumniEvent.addAttendee(student3);

        manager.addStudent(student1);
        manager.addStudent(student2);
        manager.addStudent(student3);
        Donor d1 = new Donor("96 Reblend", 5000);
        manager.addDonor(d1);

        alumniEvent.displayEventDetails();

        Scanner sc = new Scanner(System.in);
        System.out.print("Enter student ID to retrieve: ");
        String id = sc.next();
        Student retrievedStudent = manager.getStudent(id);
        if (retrievedStudent != null) {
            retrievedStudent.displayInfo();
        } else {
            System.out.println("Student not found.");
        }

        System.out.print("Enter donor name to retrieve: ");
        String donorName = sc.next();
        Donor retrievedDonor = manager.getDonor(donorName);
        if (retrievedDonor != null) {
            retrievedDonor.displayInfo();
        } else {
            System.out.println("Donor not found.");
        }

        sc.close();
    }
}
