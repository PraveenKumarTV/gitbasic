package event;

import models.Student;

public class AlumniEvent {
    private String eventName;
    private String date;
    private String location;
    private Student[] attendees;
    private int maxAttendees;
    private int currentAttendeeCount;

    public AlumniEvent(String eventName, String date, String location, int maxAttendees) {
        this.eventName = eventName;
        this.date = date;
        this.location = location;
        this.maxAttendees = maxAttendees;
        this.attendees = new Student[maxAttendees];
        this.currentAttendeeCount = 0;
    }

    public boolean addAttendee(Student student) {
        if (currentAttendeeCount < maxAttendees) {
            attendees[currentAttendeeCount] = student;
            currentAttendeeCount++;
            return true;
        }
        return false; // Event is full
    }

    public void displayEventDetails() {
        System.out.println("Event Name: " + eventName);
        System.out.println("Date: " + date);
        System.out.println("Location: " + location);
        System.out.println("Attendees:");
        for (int i = 0; i < currentAttendeeCount; i++) {
            attendees[i].displayInfo();
        }
    }
}
